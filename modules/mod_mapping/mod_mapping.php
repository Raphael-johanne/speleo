<?php
/**
 * @package    aure
 * @subpackage mod_mapping
 */

// No direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

$formules = modMappingHelper::getFormules($params);
$document = JFactory::getDocument();

require JModuleHelper::getLayoutPath('mod_mapping');