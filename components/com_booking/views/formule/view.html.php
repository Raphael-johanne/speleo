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

    protected $images = [];

    protected $keyMap = null;

    /**
     * @param null $tpl
     *
     *
     * @since version
     */
	function display($tpl = null)
	{
        $app    = JFactory::getApplication();
        $locale = JFactory::getLanguage();
        $params = $app->getParams();
        $input  = $app->input;
        $id     = $input->get('id', 1, 'INT');

	    $model         = $this->getModel();
	    $this->item    = $model->getFormule($id);
        $this->images  = $model->getImages($id);
        $this->keyMap = $params->get('com_booking_formule_gmap_key', null);
        $this->localeTag = $locale->getTag();

        $pathway = $app->getPathway();
        $pathway->addItem(strip_tags($this->item->name));

        $template = $app->getTemplate(true);
        $template->params->set('bt_banner_title', $this->item->name);

        if (!empty($this->images)) {
            $template->params->set('bt_banner_bg', Juri::base() . $this->images[0]->path);  
        }

		parent::display($tpl);
	}
}
