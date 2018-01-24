<?php
/**
 * @package    aure
 * @subpackage mod_mapping
 */

// No direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
require dirname(__FILE__) . '/src/gkey.php'; // file containing the google key 

$formules = modMappingHelper::getFormules($params);
$document = JFactory::getDocument();

require JModuleHelper::getLayoutPath('mod_mapping');