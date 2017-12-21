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
 *  View
 *
 * @since  0.0.1
 */
class BookingViewBooking extends JViewLegacy
{
	/**
	 * View form
	 *
	 * @var $form
	 */
	protected $form = null;

    /**
     * @var $bookers
     */
    protected $bookers = null;

	/**
	 * Display the Booking view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	public function display($tpl = null)
	{
        $model = $this->getModel() ;
		// Get the Data
		$this->form     = $this->get('Form');
		$this->item     = $this->get('Item');
        $this->bookers  = $model->getBookers(
            $this->item->period_id,
            $this->item->date
        );

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}


		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolBar()
	{
		$input = JFactory::getApplication()->input;

		// Hide Joomla Administrator Main menu
		$input->set('hidemainmenu', true);

		$isNew = ($this->item->id == 0);

		if ($isNew)
		{
			$title = JText::_('COM_BOOKING_MANAGER_BOOKING_NEW');
		}
		else
		{
			$title = JText::_('COM_BOOKING_MANAGER_BOOKING_EDIT');
		}

		JToolbarHelper::title($title, 'booking');
		JToolbarHelper::save('booking.save');
		JToolbarHelper::cancel(
			'booking.cancel',
			$isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE'
		);
	}
}
