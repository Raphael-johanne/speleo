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

<?php echo JText::_('COM_BOOKING_SUBSCRIPTION_EMAIL_HELLO') ?>,
<br />
<br />
<?php echo JText::_('COM_BOOKING_SUBSCRIPTION_EMAIL_INFO', $this->booking->sys_name) ?> : <?php echo $this->booking->sys_name ?>
<br />
<br />
<ul>
    <li>
        <?php echo JText::_('COM_BOOKING_FIRSTNAME') ?> : <?php echo $this->booking->firstname ?>
    </li>
    <li>
        <?php echo JText::_('COM_BOOKING_LASTNAME') ?> : <?php echo $this->booking->lastname ?>
    </li>
    <li>
        <?php echo JText::_('COM_BOOKING_EMAIL') ?> : <?php echo $this->booking->email ?>
    </li>
    <li>
        <?php echo JText::_('COM_BOOKING_NBR_PERSON') ?> : <?php echo $this->booking->nbr_person ?>
    </li>
    <li>
        <?php echo JText::_('COM_BOOKING_DATE') ?> : <?php echo $this->booking->date ?>
    </li>
</ul>
<br />
<br />
<?php echo JText::_('COM_BOOKING_SUBSCRIPTION_EMAIL_THANK') ?> !
