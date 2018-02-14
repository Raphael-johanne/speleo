<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<form action="index.php?option=com_booking&view=bookings" method="post" id="adminForm" name="adminForm">
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="1%"><?php echo JText::_('COM_BOOKING_NUM'); ?></th>
			<th width="2%">
				<?php echo JHtml::_('grid.checkall'); ?>
			</th>
			<th width="10%">
				<?php echo JText::_('COM_BOOKING_DATE') ;?>
			</th>
            <th width="10%">
                <?php echo JText::_('COM_BOOKING_PERIOD'); ?>
            </th>
			<th width="60%">
				<?php echo JText::_('COM_BOOKING_FORMULE'); ?>
			</th>
			<th width="5%">
				<?php echo JText::_('COM_BOOKING_PRICE'); ?>
			</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) : ?>
					<tr>
						<td>
							<?php echo $this->pagination->getRowOffset($i); ?>
						</td>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td>
							<a href="<?php echo JRoute::_('index.php?option=com_booking&task=booking.edit&id=' . $row->id); ?>" title="<?php echo JText::_('COM_BOOKING_EDIT_BOOKING'); ?>">
								<?php echo $row->date; ?>
							</a>
						</td>
                        <td>
                            <?php echo $row->periodName; ?>
                        </td>
						<td>
							<?php echo $row->sys_name; ?>
						</td>
						<td>
							<?php echo $row->totalPrice; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<?php echo JHtml::_('form.token'); ?>
</form>
