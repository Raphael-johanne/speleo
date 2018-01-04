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

<h3>Subscription</h3>
<form name="subscription">
    <label for="firstname">
        Firstname *
    </label>
    <input id="firstname" type="text" name="form[firstname]" />

    <label for="lastname">
        Lastname *
    </label>
    <input id="lastname" type="text" name="form[lastname]" />

    <label for="email">
        Email *
    </label>
    <input id="email" type="text" name="form[email]" />

    <label for="phone">
        Phone *
    </label>
    <input id="phone" type="text" name="form[phone]" />
</form>
<a href="#" id="form-save">Subscribe</a>
