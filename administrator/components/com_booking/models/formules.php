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
class BookingModelFormules extends JModelList
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

		$query->select('f.*')
                ->from($db->quoteName('#__formule', 'f'));

		return $query;
	}
}
