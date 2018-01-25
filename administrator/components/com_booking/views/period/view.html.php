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
 *  Period View
 *
 * @since  0.0.1
 */
class BookingViewPeriod extends JViewLegacy
{
    /**
     * @var null
     * @since version
     */
	protected $form = null;

    /**
     * @param null $tpl
     *
     * @return bool
     *
     * @since version
     */
	public function display($tpl = null)
	{
		// Get the Data
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');

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
		JToolbarHelper::apply('period.apply');
		JToolbarHelper::save('period.save');
		JToolbarHelper::cancel(
			'period.cancel',
			$isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE'
		);
	}
}
