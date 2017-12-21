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
 * List Model
 *
 * @since  0.0.1
 */
class BookingModelBookings extends JModelList
{
	/**
	 * Method to build an SQL query to load the list  data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select(['b.*, f.name', 'p.name as periodName', 'SUM(b.price) as totalPrice'])
                ->from($db->quoteName('#__booking', 'b'))
                ->join('INNER', $db->quoteName('#__formule', 'f') . ' ON (' . $db->quoteName('b.formule_id') . ' = ' . $db->quoteName('f.id') . ')')
                ->join('INNER', $db->quoteName('#__period', 'p') . ' ON (' . $db->quoteName('b.period_id') . ' = ' . $db->quoteName('p.id') . ')')
                ->group([$db->quoteName('date'), $db->quoteName('period_id')]);

		return $query;
	}
}
