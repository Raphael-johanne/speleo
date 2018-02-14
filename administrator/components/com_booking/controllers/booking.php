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
    const MAIL_TPL_COMFIRMED = 'email_comfirmed';
    const MAIL_TPL_CANCELED = 'email_cancel';

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
                $fields[]   = $state . ' = ' . $stateValue;
            }

            $model->update($bookingId, $fields);

            /**
            * update availibility for the formule
            */
            BookingAvailibility::update($bookingId, $fields);

            if (isset($booker['sent_email'])) {
                $booking = $model->getById($bookingId);
                $this->sendEmailNotification($booking);
            }
        }
    }

    /**
     * @param $booking
     * @since version
     */
    private function sendEmailNotification($booking) {
        
        $view           = parent::getView('booking','html');
        $view->booking  = $booking;
        $tpl            = null;

        if ($booking->is_comfirmed) {
            $tpl = self::MAIL_TPL_COMFIRMED;
        } else if ($booking->is_canceled) {
            $tpl = self::MAIL_TPL_CANCELED;
        }

        try {
            BookingHelperMailer::send(
                'Your subscription',
                $booking->email,
                $view->loadTemplate($tpl)
            );
        } catch (Exception $e) {
             JLog::add($e->getMessage(), JLog::ERROR, 'com_booking');
        }
    }
}
