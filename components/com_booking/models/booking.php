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
class BookingModelBooking extends BookingAvailibility
{
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
