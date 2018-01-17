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
 * Booking Model
 *
 * @since  0.0.1
 */
class BookingModelBooking extends JModelItem
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
     * @param $formuleId
     *
     * @return mixed
     *
     * @since version
     */
	public function getAvailableDates($formuleId, $nbrPerson)
	{
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select(['fd.date'])
            ->from($db->quoteName('#__formule_date', 'fd'))
            ->where(sprintf('fd.formule_id = %d AND fd.place_remaining - %d > 0',
                (int) $formuleId,
                (int) $nbrPerson
            ))
            ->group('fd.date');

        $db->setQuery($query);

        return $db->loadColumn();
	}

    /**
     * @param $formuleId
     * @param $date
     *
     * @return mixed
     *
     * @since version
     */
    public function getAvailabePeriods($formuleId, $date, $nbrPerson)
    {
        $db         = JFactory::getDbo();
        $query      = $db->getQuery(true);
        $language   = JFactory::getLanguage();

        list($selects, $lefts) = BookingHelperLocalized::localized(
            BookingPeriod::getAttributes(),
            BookingPeriod::ENTITY_TYPE,
            $language->getTag()
        );

        $selects[] = 'main.*';

        $query->select($selects)
            ->from($db->quoteName('#__period', 'main'))
            ->join('INNER', $db->quoteName('#__formule_date', 'fd') . ' ON (' . $db->quoteName('fd.period_id') . ' = ' . $db->quoteName('main.id') . ')')
            ->where(sprintf('fd.formule_id = %d AND fd.date = %s AND fd.place_remaining - %d > 0 ',
                (int) $formuleId,
                $db->quote($date),
                (int) $nbrPerson
            ));

        foreach ($lefts as $left) {
            $query->join('LEFT', $left);
        }

        $db->setQuery($query);

        return $db->loadObjectList();
    }

    /**
     * @param $encryptionKey
     *
     * @return mixed
     *
     * @since version
     * @throws Exception
     */
    public function getByKey($encryptionKey) {
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select(['b.*', 'p.hour'])
            ->from($db->quoteName('#__booking', 'b'))
            ->join('INNER', $db->quoteName('#__period', 'p') . ' ON (' . $db->quoteName('p.id') . ' = ' . $db->quoteName('b.period_id') . ')')
            ->where('b.encrypt = ' .  $db->quote($encryptionKey) )
            ->where('b.cdate < ' .  $db->quote(date("Y-m-d H:i:s", strtotime("+1 hours"))) )
            ->where('b.is_comfirmed = 0 AND b.is_canceled = 0');

        $db->setQuery($query);
        $booking = $db->loadObject();

        if (null === $booking) {
            throw new Exception('Subscription error, please contact admin');
        }

        return $booking;
    }

    /**
     * @param $bookingId
     *
     *
     * @since version
     */
    public function update($bookingId){
        $db    = JFactory::getDBO();
        $fields = [];
        $query      = $db->getQuery(true);
        $fields[]   = 'is_comfirmed = 1';
        $query->update('#__booking')
        ->set($fields)
        ->where('id = ' . (int) $bookingId);
        $db->setQuery($query);
        $db->execute();

        /**
        * select the current booking information
        */
        $query      = $db->getQuery(true);
        $query->select(['b.formule_id', 'b.period_id', 'b.date'])
            ->from($db->quoteName('#__booking', 'b'))
            ->where('b.id = ' . (int) $bookingId );

        $db->setQuery($query);
        $booking = $db->loadObject();

        /**
        * get remaining places for current formule / day / period
        */
        $query      = $db->getQuery(true);
        $query->select(['SUM(nbr_person) as place_remaining'])
            ->from($db->quoteName('#__booking'))
            ->where('formule_id = ' . (int) $booking->formule_id )
            ->where('period_id = ' . (int) $booking->period_id )
            ->where('is_comfirmed = 1' )
            ->where('date = ' .  $db->quote($booking->date));

        $db->setQuery($query);
        $placeRamaining = $db->loadColumn();

        $query  = $db->getQuery(true);
        $fields = ['place_remaining = place_remaining - ' . (int) $placeRamaining[0]];
       
        $query->update('#__formule_date')
            ->set($fields)
            ->where('formule_id = ' . (int) $booking->formule_id )
            ->where('period_id = ' . (int) $booking->period_id )
            ->where('date = ' . $db->quote($booking->date));

        $db->setQuery($query);
        $db->execute();    
    }

    /**
     * @param array $data
     *
     *
     * @since version
     */
    public function saveSubscription(
        array $data,
        $ip,
        $encryptionKey
    ) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $columns = [
            'formule_id',
            'nbr_person',
            'price',
            'date',
            'is_canceled',
            'is_private',
            'is_comfirmed',
            'period_id',
            'firstname',
            'lastname',
            'email',
            'phone',
            'ip',
            'address',
            'zip_code',
            'country',
            'encrypt',
            'cdate',
            'udate',
        ];

        $values = [
            (int) $data['formule_id'],
            (int) $data['howmuch'],
            $data['price'],
            'STR_TO_DATE("'.$data['date'].'", "%m/%d/%Y")',
            0,
            0,
            0,
            (int) $data['period'],
            $db->quote($data['form']['firstname']),
            $db->quote($data['form']['lastname']),
            $db->quote($data['form']['email']),
            $db->quote($data['form']['phone']),
            $db->quote($ip),
            'null',
            'null',
            'null',
            $db->quote($encryptionKey),
            $db->quote(date("Y-m-d H:i:s")),
            $db->quote(date("Y-m-d H:i:s"))
        ];

        $query
            ->insert($db->quoteName('#__booking'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
        $db->setQuery($query);
        $db->execute();
    }
}
