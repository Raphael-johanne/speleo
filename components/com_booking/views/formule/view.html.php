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
     *
     * @since version
     */
	function display($tpl = null)
	{
        $input  = JFactory::getApplication()->input;
        $id     = $input->get('id', 1, 'INT');

	    $model         = $this->getModel();
	    $this->item    = $model->getFormule($id);
        $this->images  = $model->getImages($id);

        $template = JFactory::getApplication()->getTemplate(true);
        $template->params->set('bt_banner_title', $this->item->name);
        if (!empty($this->images)) {
            $template->params->set('bt_banner_bg', Juri::base() . $this->images[0]->path);  
        }

        $locale = JFactory::getLanguage();
        $this->localeTag = $locale->getTag();

		parent::display($tpl);
	}
}
