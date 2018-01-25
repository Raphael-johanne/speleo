<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

require_once JPATH_COMPONENT . '/helpers/encrypt.php';
require_once JPATH_COMPONENT . '/helpers/mailer.php';
require_once JPATH_COMPONENT . '/helpers/localized.php';
require_once JPATH_COMPONENT . '/models/BookingFormule.php';
require_once JPATH_COMPONENT . '/models/BookingPeriod.php';
require_once JPATH_COMPONENT . '/models/BookingAvailibility.php';

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Get an instance of the controller prefixed by Booking
$controller = JControllerLegacy::getInstance('Booking');

// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
