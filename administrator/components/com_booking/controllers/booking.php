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
class BookingControllerBooking extends JControllerForm
{
    /**
     * @param $model
     * @param $validData
     *
     *
     * @since version
     */
    protected function postSaveHook($model, $validData) {
        $bookers = JRequest::getVar('bookers', []);
        $model->updateBookersState($bookers);
    }
}
