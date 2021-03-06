<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Booking Table class
 *
 * @since  0.0.1
 */
class BookingTableBooking extends JTable
{
    /**
     * BookingTableBooking constructor.
     * @param $db
     */
	function __construct(&$db)
	{
		parent::__construct('#__booking', 'id', $db);
	}
}
