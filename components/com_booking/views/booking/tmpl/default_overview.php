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
<section class="widget-single widget-categories">
	<h4 class="hr-primary"><?php echo JText::_('COM_BOOKING_OVERVIEW_BOOK_ACTIVITY') ?></h4>
	<ol>
		<li>
			<?php echo JText::_('COM_BOOKING_NBR_PERSON') ?>
			<?php echo (isset($this->data['howmuch'])) ? '<span>' . $this->data['howmuch'] . '</span>': ''; ?>
		</li>
		<li>
			<?php echo JText::_('COM_BOOKING_OVERVIEW_DATE') ?>
			<b><?php echo (isset($this->data['date'])) ? $this->data['date'] : ''; ?></b>
		</li>
		<li>
			<?php echo JText::_('COM_BOOKING_OVERVIEW_PERIOD') ?>
			<b><?php echo (isset($this->data['period'])) ? $this->data['period'] : ''; ?></b>
		</li>
		<li>
			<?php echo JText::_('COM_BOOKING_OVERVIEW_SUBSCRIPTION') ?>
		</li>
		<li>
			<?php echo JText::_('COM_BOOKING_OVERVIEW_BOOK_PRICE') ?>
			<span><?php echo (isset($this->data['price'])) ? $this->data['price'] : 0; ?></span>
		</li>	
	</ol>
</section>
