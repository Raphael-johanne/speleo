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
 *  Controller
 *
 * @package     racol
 * @subpackage  com_booking
 * @since       0.0.9
 */
class BookingControllerPeriod extends JControllerForm
{
	/**
     * @param $model
     * @param $validData
     *
     *
     * @since version
     */
    protected function postSaveHook($model, $validData) {
        $item       = $model->getItem();
        $itemId     = $item->get('id');
        $attributes = JRequest::getVar('attributes', []);
        $model->updateLocalized($itemId, $attributes);
    }
}
