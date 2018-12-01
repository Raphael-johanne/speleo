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
<h5 class="hr-primary"><?php echo JText::_('COM_BOOKING_HOW_MUCH_PERSON') ?></h5>
<select id="howmuch">
    <?php for ($i = 1; $i <= $this->formule->max_person_allowed; $i++) : ?>
        <option value="<?php echo $i ?>"><?php echo $i ?></option>
    <?php endfor; ?>
</select>
