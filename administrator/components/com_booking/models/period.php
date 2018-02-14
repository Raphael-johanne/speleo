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
class BookingModelPeriod extends JModelAdmin
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
	public function getTable($type = 'Period', $prefix = 'BookingTable', $config = [])
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
		// Get the form.
		$form = $this->loadForm(
			'com_booking.period',
			'period',
			[
				'control'   => 'jform',
				'load_data' => $loadData
            ]
		);

		if (empty($form)) {
			return false;
		}

		return $form;
	}

	public function updateLocalized($id, $attributes) {
		$this->saveLocalized(
			$id,
			BookingPeriod::ENTITY_TYPE,
			$attributes
		);
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
			'com_booking.edit.period.data',
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
        $item->attributes   = [];

        $language = JFactory::getLanguage();
        $locales = array_keys($language->getKnownLanguages());

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
            BookingPeriod::getAttributes(),
            BookingPeriod::ENTITY_TYPE,
            $locale
        );

        $query->select($selects);
        $query->from('#__period main')
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
}
