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
     * @param $howMuch
     * @param null $date
     *
     * @return mixed
     *
     * @since version
     */
	public function getUnavailabeDate($howMuch, $date = null)
	{
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select(['b.*', 'SUM(b.nbr_person)', 'f.max_person_allowed', 'f.name', 'f.id', 'b.period_id'])
            ->from($db->quoteName('#__booking', 'b'))
            ->join('INNER', $db->quoteName('#__formule', 'f') . ' ON (' . $db->quoteName('b.formule_id') . ' = ' . $db->quoteName('f.id') . ')')
            ->where('b.is_canceled = 0 AND b.is_comfirmed = 1')
            ->having(sprintf('SUM(b.nbr_person) + %d > f.max_person_allowed OR b.is_private = 1',
                (int) $howMuch
            ))
            ->group([$db->quoteName('date'), $db->quoteName('period_id')]);

        if ($date !== null) {
            $query->where('b.date = ' . $db->quote($date));
        }

        $db->setQuery($query);

        return $db->loadObjectList();
	}

    /**
     * @param $formuleId
     * @param $howMuch
     * @param $date
     *
     * @return mixed
     *
     * @since version
     */
    public function getAvailabePeriods($formuleId, $howMuch, $date)
    {
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);
        $unavailableDates = $this->getUnavailabeDate($howMuch, $date);

        $periodsUnavailable = [];
        foreach ($unavailableDates as $unavailableDate) {
            $periodsUnavailable[] = (int) $unavailableDate->period_id;
        }

        $query->select('p.*')
            ->from($db->quoteName('#__period', 'p'))
            ->join('INNER', $db->quoteName('#__formule_period', 'fp') . ' ON (' . $db->quoteName('p.id') . ' = ' . $db->quoteName('fp.period_id') . ')')
            ->where(
                sprintf('fp.formule_id = %d',
                    (int) $formuleId
                )
            );

        if (!empty($periodsUnavailable)) {
            $query->where(
                sprintf('p.id NOT IN (%s)',
                    implode(',', $periodsUnavailable)
                    )
                );
        }

        $db->setQuery($query);
        return $db->loadObjectList();
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

        $query->select(['b.*', 'p.name', 'p.hour'])
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
    public function updateComfirmed($bookingId){
        $db    = JFactory::getDBO();

        $query = $db->getQuery(true);
        $fields[] = 'is_comfirmed = 1';

        $query->update('#__booking')
        ->set($fields)
        ->where('id = ' . (int) $bookingId);

        $db->setQuery($query);

        $db->execute();
    }
}
