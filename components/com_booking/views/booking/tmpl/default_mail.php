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
<?php echo JText::_('COM_BOOKING_SUBSCRIPTION_EMAIL_INFO', $this->formule->name) ?> : <?php echo $this->formule->name ?>
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
    <li>
        <?php echo JText::_('COM_BOOKING_PERIOD') ?> : <?php echo $this->booking->name ?> - <?php echo $this->booking->hour ?>
    </li>
</ul>
<br />
<b><?php echo JText::_('COM_BOOKING_SUBSCRIPTION_EMAIL_ONE_HOUR_TO_COMFIRM') ?></b>
<br />
<b><?php echo JText::_('COM_BOOKING_SUBSCRIPTION_EMAIL_FOLLOW_LINK') ?> :</b>
<br />
<br />
<a href="<?php echo JURI::root() . $this->comfirmLink ?>"><?php echo JText::_('COM_BOOKING_SUBSCRIPTION_EMAIL_COMFIRM_SUBSCRIPTION') ?></a>
<br />
<br />
<?php echo JText::_('COM_BOOKING_SUBSCRIPTION_EMAIL_THANK') ?> !
