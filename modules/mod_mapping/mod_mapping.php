<?php
/**
 * @package    aure
 * @subpackage mod_mapping
 */
// No direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/src/gkey.php';// file containing the google key
require_once dirname(__FILE__) . '/../../components/com_booking/models/BookingFormule.php';
require_once dirname(__FILE__) . '/../../components/com_booking/helpers/localized.php';
require_once dirname(__FILE__) . '/../../components/com_booking/models/formules.php';

$bookingModelFormules = new BookingModelFormules();
$formules = $bookingModelFormules->getFormules();
$document = JFactory::getDocument();

require JModuleHelper::getLayoutPath('mod_mapping');
