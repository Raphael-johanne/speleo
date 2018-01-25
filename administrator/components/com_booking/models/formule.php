<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 *  Model
 *
 * @since  0.0.1
 */
class BookingModelFormule extends JModelAdmin
{
	use localized;

	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Formule', $prefix = 'BookingTable', $config = [])
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed    A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = [], $loadData = true)
	{
		$form = $this->loadForm(
			'com_booking.formule',
			'formule',
			[
				'control' => 'jform',
				'load_data' => $loadData
            ]
		);

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState(
			'com_booking.edit.formule.data',
            []
		);

		if (empty($data)) {
			$data = $this->getItem();
		}
        
		return $data;
	}

    /**
     *
     * @return mixed
     *
     * @since version
     */
	public function getItem() {
		$item = parent::getItem();

        $item->period_ids   = $this->getPeriods($item->id);
        $item->dates        = $this->getDates($item->id);
        $item->attributes   = [];

        $language   = JFactory::getLanguage();
        $locales    = array_keys($language->getKnownLanguages());

        foreach ($locales as $locale) {
			$item->attributes[$locale]	= $this->getAttributes($item->id, $locale);
        }

        return $item;
	}

    /**
     * @param $id
     *
     * @return mixed
     *
     * @since version
     */
    protected function getAttributes($id, $locale)
    {
        $db    = $this->getDbo();
        $query = $db->getQuery(true);

        list($selects, $lefts) = BookingHelperLocalized::localized(
            BookingFormule::getAttributes(),
            BookingFormule::ENTITY_TYPE,
            $locale
        );

        $query->select($selects);
        $query->from('#__formule main')
            ->where(
                sprintf('main.id = %d',
                    (int) $id
                )
            );

        foreach ($lefts as $left) {
            $query->join('LEFT', $left);
        }
		
        $db->setQuery((string) $query);
        return $db->loadObject();
    }


    /**
     * @param $id
     *
     * @return mixed
     *
     * @since version
     */
    private function getDates($id) {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('fd.date');
        $query->from('#__formule_date fd')
            ->where('fd.formule_id = ' . (int) $id);
        $db->setQuery((string) $query);
        return $db->loadColumn();
    }

    /**
     * @param $id
     *
     * @return mixed
     *
     * @since version
     */
    private function getPeriods($id) {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('fp.period_id');
        $query->from('#__formule_period fp')
            ->where('fp.formule_id = ' . (int) $id);
        $db->setQuery((string) $query);
        return $db->loadColumn();
    }

    public function updateLocalized($id, $attributes) {
		$this->saveLocalized(
			$id,
			BookingFormule::ENTITY_TYPE,
			$attributes
		);
    }

    public function updatePeriods($id, $validData) {
        $db         = JFactory::getDbo();
        $values     = [];
        $columns    = ['formule_id', 'period_id'];
        $query      = $db->getQuery(true);

        $query->delete($db->quoteName('#__formule_period'));
        $query->where($db->quoteName('formule_id') . ' = ' . (int) $id);
        $db->setQuery($query);
        $db->query();

        $query = $db->getQuery(true);

        foreach ($validData['period_ids'] as $periodId) {
            $values[] = (int) $id .', '.(int) $periodId;
        }

        $query->insert($db->quoteName('#__formule_period'));
        $query->columns($columns);
        $query->values($values);
        $db->setQuery($query);
        $db->query();
    }

    public function updateAvailableDates($id, $dates, $validData) {

        $dates  = explode(', ', $dates);
        $db     = JFactory::getDbo();

        /**
        * get used dates
        */
        $query      = $db->getQuery(true);
        $query->select('date');
        $query->from($db->quoteName('#__formule_date'));
        $query->where($db->quoteName('place_remaining') . ' < ' . (int) $validData['max_person_allowed']);
        $query->where($db->quoteName('date') . ' > ' . $db->quote(date("Y-m-d", strtotime("now"))));
        $query->where($db->quoteName('formule_id') . ' = ' . (int) $id);
        $db->setQuery($query);
      
        $usedDates = $db->loadColumn();

        /**
        * clean useless date
        */
        $query      = $db->getQuery(true);
        $query->delete($db->quoteName('#__formule_date'));
        if (!empty($usedDates)) {
            $usedDates;
            foreach ($usedDates as $k => $date) {
                $usedDates[$k] = $db->quote($date);
            }
            $query->where($db->quoteName('date') . ' NOT IN ' . '(' . implode(',', $usedDates) . ')');
        }
        
        $query->where($db->quoteName('formule_id') . ' = ' . (int) $id);
        $db->setQuery($query);
        $db->query();

        $columns    = ['formule_id', 'period_id', 'date', 'place_remaining'];
        $values     = [];
        foreach ($validData['period_ids'] as $periodId) {
            foreach ($dates as $date) {
                if (!in_array($db->quote($date), $usedDates)) {   
                    $values[] = (int) $id . ', '.(int) $periodId . ', ' . $db->quote(date("Y-m-d", strtotime($date))) . ', ' . (int) $validData['max_person_allowed'];
                }
            }
        }  

        if (!empty($values)) {
            $query  = $db->getQuery(true);
            $query->insert($db->quoteName('#__formule_date'));
            $query->columns($columns);
            $query->values($values);
            $db->setQuery($query);
            $db->query();
        }
    }
}
