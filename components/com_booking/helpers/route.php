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
class BookingHelperRoute
{
    /**
     * @param $id
     * @param $name
     *
     * @return string
     *
     * @since version
     */
    public static function getFormuleRoute($id, $name) {
        $name = JFilterOutput::stringURLSafe(strip_tags($name));
        return 'index.php?option=com_booking&view=formule&id=' . $id . '&slug=' . $name;
    }
}
