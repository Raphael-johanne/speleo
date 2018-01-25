<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>

<h3><?php echo JText::_('COM_BOOKING_SUBSCRIPTION') ?></h3>
<form name="subscription">
    <label for="firstname">
        <?php echo JText::_('COM_BOOKING_FIRSTNAME') ?>
    </label>
    <input id="firstname" type="text" name="form[firstname]" />

    <label for="lastname">
        <?php echo JText::_('COM_BOOKING_LASTNAME') ?>
    </label>
    <input id="lastname" type="text" name="form[lastname]" />

    <label for="email">
        <?php echo JText::_('COM_BOOKING_EMAIL') ?>
    </label>
    <input id="email" type="text" name="form[email]" />

    <label for="phone">
        <?php echo JText::_('COM_BOOKING_PHONE') ?>
    </label>
    <input id="phone" type="text" name="form[phone]" />
</form>