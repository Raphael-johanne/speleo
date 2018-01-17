<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

require_once JPATH_COMPONENT_SITE . '/helpers/localized.php';
require_once JPATH_COMPONENT_SITE . '/models/BookingFormule.php';
require_once JPATH_COMPONENT_SITE . '/models/BookingPeriod.php';
require_once JPATH_COMPONENT . '/models/trait/localized.php';

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Get an instance of the controller prefixed by Booking
$controller = JControllerLegacy::getInstance('Booking');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
