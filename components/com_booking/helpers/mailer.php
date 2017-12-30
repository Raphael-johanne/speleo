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
 * Content Component Route Helper.
 *
 * @since  1.5
 */
abstract class BookingHelperMailer
{
    /**
     * @param $recipients
     * @param $body
     * @param bool $isHtml
     * @param array $sender
     *
     *
     * @since version
     */
    public static function send(
        $subject,
        $recipients,
        $body,
        $isHtml = true,
        $sender = []
    )
    {
        $mailer = JFactory::getMailer();
        $config = JFactory::getConfig();

        if (empty($sender)) {
            $sender = [
                $config->get( 'mailfrom' ),
                $config->get( 'fromname' )
            ];
        }

        $mailer->setSubject($subject);
        $mailer->setSender($sender);
        $mailer->addRecipient($recipients);
        $mailer->isHtml($isHtml);
        $mailer->setBody($body);
        $mailer->Encoding = 'base64';
        $send = $mailer->Send();
        if ( $send !== true ) {
            throw new Exception(sprintf('Error during sending mail : %s', $subject));
        }
    }
}
