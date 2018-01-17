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
    public function check()
    {
        $key = $this->input->get('key');

        if ($this->isValid($key)) {
            // will throw an exception, catched by joomla, if not exist
            $booking = $this->getModel('booking')->getByKey($key);

            $this->getModel('booking')->update($booking->id);
            $this->setRedirect('index.php', JText::_('COM_BOOKING_SUBSCRIPTION_COMFIRMATION_MESSAGE'));
        } else {
            $this->setRedirect('index.php', JText::_('COM_BOOKING_SUBSCRIPTION_FAIL_MESSAGE'));
        }
    }

    /**
     * @param $key
     *
     * @return string
     *
     * @since version
     */
    private function isValid($key)
    {
        return BookingHelperEncrypt::isValid($key);
    }
}
