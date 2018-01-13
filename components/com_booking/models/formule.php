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
 * Formule Model
 *
 * @since  0.0.1
 */
class BookingModelFormule extends JModelItem
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
	public function getTable($type = 'Formule', $prefix = 'BookingTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

    /**
     * @param $id
     *
     * @return object
     *
     * @since version
     * @throws Exception
     */
	public function getFormule($id)
	{
        $table = $this->getTable();
        $table->load($id);
        $properties = $table->getProperties(1);

        if (null === $properties['id']) {
            throw new Exception('Formule does not exist');
        }

        return ArrayHelper::toObject($properties, 'JObject');
	}
}
