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
JLoader::register('BookingHelperRoute', JPATH_SITE . '/components/com_booking/helpers/route.php');

/**
 * HTML View class for the Booking Component
 *
 * @since  0.0.1
 */
class BookingViewFormules extends JViewLegacy
{
    protected $items = null;

    /**
     * @param null $tpl
     *
     * @return bool
     *
     * @since version
     */
	function display($tpl = null)
	{
		$this->items = $this->get('Formules');

		if (count($errors = $this->get('Errors')))
		{
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

			return false;
		}

		parent::display($tpl);
	}
}
