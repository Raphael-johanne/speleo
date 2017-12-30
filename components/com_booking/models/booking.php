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
     *
     * @return mixed
     *
     * @since version
     */
	public function getUnavailabeDate($howMuch)
	{
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select(['b.*', 'SUM(b.nbr_person)', 'f.max_person_allowed', 'f.name'])
            ->from($db->quoteName('#__booking', 'b'))
            ->join('INNER', $db->quoteName('#__formule', 'f') . ' ON (' . $db->quoteName('b.formule_id') . ' = ' . $db->quoteName('f.id') . ')')
            ->where('b.is_canceled = 0')
            ->having(sprintf('SUM(b.nbr_person) + %d > f.max_person_allowed OR b.is_private = 1', (int) $howMuch))
            ->group([$db->quoteName('date'), $db->quoteName('period_id')]);

        $db->setQuery($query);

        return $db->loadObjectList();
	}

    /**
     * @param $howMuch
     *
     * @return mixed
     *
     * @since version
     */
    public function getAvailabePeriods($howMuch)
    {
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select(['b.period_id', 'b.date', 'f.max_person_allowed'])
            ->from($db->quoteName('#__booking', 'b'))
            ->join('INNER', $db->quoteName('#__formule', 'f') . ' ON (' . $db->quoteName('b.formule_id') . ' = ' . $db->quoteName('f.id') . ')')
            ->having(sprintf('SUM(b.nbr_person) + %d <= f.max_person_allowed', (int) $howMuch))
            ->where('b.is_private = 0')
            ->group([$db->quoteName('date'), $db->quoteName('period_id')]);

        $db->setQuery($query);
        $periodIds = $db->loadColumn();

        $query = $db->getQuery(true);
        $query->select('p.*')
            ->from($db->quoteName('#__period', 'p'))
            ->where(sprintf('p.id IN (%s)', implode(', ', $periodIds)));

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
            Date('now'),
            Date('now')
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

        $query->select(['b.id'])
            ->from($db->quoteName('#__booking', 'b'))
            ->where('b.encrypt = ' .  $db->quote($encryptionKey) );

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
        $fields[] = $db->quoteName('is_comfirmed') . ' = 1';

        $query->update('#__booking b')
        ->set($fields)
        ->where('b.id = ' . (int) $bookingId);

        $db->setQuery($query);

        $db->execute();
    }
}
