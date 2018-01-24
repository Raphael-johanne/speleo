<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

class BookingAvailibility extends JModelItem
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
	public function getTable($type = 'Booking', $prefix = 'BookingTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	 /**
     * @param $bookingId
     *
     *
     * @since version
     */
    public static function update($bookingId, $states)
    {
        $db    = JFactory::getDBO();
        $query      = $db->getQuery(true);
        $query->update('#__booking')
        ->set($states)
        ->where('id = ' . (int) $bookingId);
        $db->setQuery($query);
        $db->execute();

        /**
        * select the current booking information
        */
        $query = $db->getQuery(true);
        $query->select(['b.formule_id', 'b.period_id', 'b.date', 'f.max_person_allowed'])
            ->join('INNER', $db->quoteName('#__formule', 'f') . ' ON (' . $db->quoteName('f.id') . ' = ' . $db->quoteName('b.formule_id') . ')')
            ->from($db->quoteName('#__booking', 'b'))
            ->where('b.id = ' . (int) $bookingId );

        $db->setQuery($query);
        $booking = $db->loadObject();

        /**
        * get busy places for current formule / day / period
        */
        $query      = $db->getQuery(true);
        $query->select(['SUM(nbr_person) as place_remaining'])
            ->from($db->quoteName('#__booking'))
            ->where('formule_id = ' . (int) $booking->formule_id )
            ->where('period_id = ' . (int) $booking->period_id )
            ->where('is_comfirmed = 1' )
            ->where('date = ' .  $db->quote($booking->date));

        $db->setQuery($query);
        $busyPlaces = $db->loadColumn();

        $busyPlaces = ($busyPlaces[0]) ?: 0;

        $query  = $db->getQuery(true);
        $fields = ['place_remaining = ' . ((int) $booking->max_person_allowed - (int) $busyPlaces)];
       
        $query->update('#__formule_date')
            ->set($fields)
            ->where('formule_id = ' . (int) $booking->formule_id )
            ->where('period_id = ' . (int) $booking->period_id )
            ->where('date = ' . $db->quote($booking->date));

        $db->setQuery($query);
        $db->execute();    
    }
}
