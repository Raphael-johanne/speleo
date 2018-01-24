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
        
        foreach ($bookers as $bookingId => $booker) {

            $fields = [];
          

            foreach (['is_comfirmed', 'is_canceled', 'is_private'] as $state) {
                $stateValue = isset($booker[$state]) ? 1 : 0;
                $fields[] = $state . ' = ' . $stateValue;

                if (isset($booker['sent_email'])) {
                    $this->sendEmailNotification($bookingId, $state);
                }
            }

            $model->update($bookingId, $fields);

            /**
            * update availibility for the formule
            */
            BookingAvailibility::update($bookingId, $fields);
        }
    }

    /**
     * @param $bookingId
     * @param $state
     *
     * @todo
     *
     * @since version
     */
    private function sendEmailNotification($bookingId, $state) {
        switch ($state) {
            case 'is_comfirmed':
                
            break;
            case 'is_canceled':

            break;
        }
    }
}
