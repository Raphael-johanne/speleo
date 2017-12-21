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

JFormHelper::loadFieldClass('list');

/**
 *  Form Field class for the  component
 *
 * @since  0.0.1
 */
class JFormFieldPeriod extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'booking';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array  An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id, name');
		$query->from('#__period');
		$db->setQuery((string) $query);
        $items = $db->loadObjectList();
		$options  = array();

		if ($items)
		{
			foreach ($items as $item)
			{
				$options[] = JHtml::_('select.option', $item->id, $item->name);
			}
		}

		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
