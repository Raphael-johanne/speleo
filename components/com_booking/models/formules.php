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

/**
 * Formules Model
 *
 * @since  0.0.1
 */
class BookingModelFormules extends JModelItem
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
     *
     * @return mixed
     *
     * @since version
     */
	public function getFormules()
	{
        $db    = $this->getDbo();
        $query = $db->getQuery(true);
        $query->select('f.*');
        $query->from('#__formule f')
            ->where('f.is_published = 1')
            ->order ('f.order DESC');
        $db->setQuery((string) $query);
        return $db->loadObjectList();
	}
}
