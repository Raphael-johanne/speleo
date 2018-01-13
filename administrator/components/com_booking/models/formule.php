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
			$data               = $this->getItem();
            $data->period_ids   = $this->getFormulePeriods($data->id);
		}

		return $data;
	}

    /**
     * @param $formuleId
     *
     * @return mixed
     *
     * @since version
     */
    private function getFormulePeriods($formuleId) {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('fp.period_id');
        $query->from('#__formule_period fp')
            ->where('fp.formule_id = ' . (int) $formuleId);
        $db->setQuery((string) $query);
        return $db->loadColumn();
    }
}
