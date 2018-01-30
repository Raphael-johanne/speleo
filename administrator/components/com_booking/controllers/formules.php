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
 * Bookings Controller
 *
 * @since  0.0.1
 */
class BookingControllerFormules extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 *
	 * @since   1.6
	 */
	public function getModel(
	    $name = 'Formules',	
        $prefix = 'BookingModel',
        $config = ['ignore_request' => true]
    ) {
        return parent::getModel($name, $prefix, $config);
	}

	
	public function delete() {
		$ids    = $this->input->get('cid', array(), 'array');
		
		if (empty($ids)) {
			JError::raiseWarning(500, JText::_('COM_BOOKING_NO_FORMULA_SELECTED'));
		} else {
			$model = $this->getModel();

			foreach ($ids as $id) {
				if ($model->canDelete($id)) {
					$model->delete($id);
				}
			}
		}

		$this->setRedirect('index.php?option=com_booking&view=formules');
	}
}
