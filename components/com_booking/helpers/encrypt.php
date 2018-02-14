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
 * Content Component Encrypt Helper.
 *
 * @since  1.5
 */
class BookingHelperEncrypt
{
    /**
     * @param $string
     *
     * @return string
     *
     * @since version
     */
    public static function encrypt($string)
    {
       return sha1($string);
    }

    /**
     * @param $key
     *
     * @return bool
     *
     * @since version
     */
    public static function isValid($key)
    {
        /**
         * basic validation to avoid useless query on db if key is not correct
         */
        return strlen($key) === 40;
    }
}
