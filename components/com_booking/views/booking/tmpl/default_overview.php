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
<?php echo JText::_('COM_BOOKING_OVERVIEW_BOOK_ACTIVITY') ?>
<br />
<?php echo JText::_('COM_BOOKING_OVERVIEW_BOOK_PRICE') ?>&nbsp; <?php echo (isset($this->data['price'])) ? $this->data['price'] : 0; ?>
<ul>
	<li>
		<?php echo JText::_('COM_BOOKING_OVERVIEW_QTY') ?>
		<br />
		<?php echo (isset($this->data['howmuch'])) ? $this->data['howmuch'] : ''; ?>
	</li>
	<li>
		<?php echo JText::_('COM_BOOKING_OVERVIEW_DATE') ?>
		<br />
		<?php echo (isset($this->data['date'])) ? $this->data['date'] : ''; ?>
	</li>
	<li>
		<?php echo JText::_('COM_BOOKING_OVERVIEW_PERIOD') ?>
		<br />
		<?php echo (isset($this->data['period'])) ? $this->data['period'] : ''; ?>
	</li>
	<li>
		<?php echo JText::_('COM_BOOKING_OVERVIEW_SUBSCRIPTION') ?>
	</li>
</ul>