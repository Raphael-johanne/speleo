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
class BookingModelBooking extends JModelAdmin
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
	public function getTable($type = 'Booking', $prefix = 'BookingTable', $config = [])
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
			'com_booking.booking',
			'booking',
			[
				'control' => 'jform',
				'load_data' => $loadData
            ]
		);

		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.->where('b.period_id = ' . (int) $periodId)
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState(
			'com_booking.edit.booking.data',
            []
		);

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}

/**
     * @param $periodId
     * @param $date
     *
     * @return mixed
     *
     * @since version
     */
    public function getById($id)
    {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('b.*, f.sys_name');
        $query->from('#__booking b')
        	->join('INNER', $db->quoteName('#__formule', 'f') . ' ON (' . $db->quoteName('f.id') . ' = ' . $db->quoteName('b.formule_id') . ')')
            ->where('b.id = ' . (int) $id);
        
        $db->setQuery((string) $query);

        return $db->loadObject();
    }

    /**
     * @param $periodId
     * @param $date
     *
     * @return mixed
     *
     * @since version
     */
    public function getBookers($formuleId, $periodId, $date)
    {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('b.*');
        $query->from('#__booking b')
            ->where('b.formule_id = ' . (int) $formuleId)
            ->where('b.period_id = ' . (int) $periodId)
            ->where('b.date = ' .  $db->quote($date));
        $db->setQuery((string) $query);

        return $db->loadObjectList();
    }

    /**
     * @param array $bookers
     *
     *
     * @since version
     */
    public function update($bookingId, $fields)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);

        $query->update('#__booking b')
            ->set($fields)
            ->where('b.id = ' . (int) $bookingId);

        $db->setQuery($query);

        $db->execute();
    }
}
