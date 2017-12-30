<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


defined('_JEXEC') or die;

/**
 * Controller for comfirmation
 *
 * @since  1.5.19
 */
class BookingControllerComfirmation extends JControllerForm
{
    /**
     *
     *
     * @since version
     */
    public function check(){
        $booking = $this->getModel('booking')->getByKey(
            $this->input->get('key')
        );
        $this->getModel('booking')->updateComfirmed($booking->id);
    }
}
