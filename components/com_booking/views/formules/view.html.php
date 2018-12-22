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
JLoader::register('BookingHelperRoute', JPATH_SITE . '/components/com_booking/helpers/route.php');

/**
 * HTML View class for the Booking Component
 *
 * @since  0.0.1
 */
class BookingViewFormules extends JViewLegacy
{
    protected $items = null;

    const COM_BOOKING_FORMULE_IMAGE_PATH = 'images/com_booking/formule/';

    /**
     * @param null $tpl
     *
     * @return bool
     *
     * @since version
     */
	function display($tpl = null)
	{
		$app = JFactory::getApplication();
		$params = $app->getParams();
		$this->items = $this->get('Formules');

        $template = $app->getTemplate(true);
        $template->params->set('bt_banner_title', JText::_('Formules'));

        if ($banner = $params->get('com_booking_formule_default_banner', null)) {
            $template->params->set('bt_banner_bg', Juri::base() . self::COM_BOOKING_FORMULE_IMAGE_PATH . $banner);
        }

		if (count($errors = $this->get('Errors'))) {
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

			return false;
		}

		parent::display($tpl);
	}
}
