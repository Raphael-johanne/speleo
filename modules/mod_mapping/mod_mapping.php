<?php
/**
 * @package    aure
 * @subpackage mod_mapping
 */
// No direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
require_once dirname(__FILE__) . '/src/gkey.php';// file containing the google key 

$formules = modMappingHelper::getFormules();// deprecated soon
// will be replaced by:
// require_once '/speleo/components/com_booking/models/formules.php';
// $formules = BookingModelFormules::getFormules();
$document = JFactory::getDocument();

require JModuleHelper::getLayoutPath('mod_mapping');
