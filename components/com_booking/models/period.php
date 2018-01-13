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
use Joomla\Utilities\ArrayHelper;
/**
 * Period Model
 *
 * @since  0.0.1
 */
class BookingModelPeriod extends JModelItem
{
	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Period', $prefix = 'BookingTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

    /**
     *
     * @return mixed
     *
     * @since version
     */
	public function getPeriod($id)
	{
        $table = $this->getTable();
        $table->load($id);
        $properties = $table->getProperties(1);

        return ArrayHelper::toObject($properties, 'JObject');
	}


}
