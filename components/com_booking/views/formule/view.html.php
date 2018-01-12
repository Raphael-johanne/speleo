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
 * HTML View class for the Booking Component
 *
 * @since  0.0.1
 */
class BookingViewFormule extends JViewLegacy
{
    protected $item = null;

    /**
     * @param null $tpl
     *
     * @return bool
     *
     * @since version
     */
	function display($tpl = null)
	{
        $input  = JFactory::getApplication()->input;
        $id     = $input->get('id', 1, 'INT');

	    $model = $this->getModel();
	    $this->item = $model->getFormule($id);

		parent::display($tpl);
	}

	public function toto(){
	    die('toto');
    }
}
