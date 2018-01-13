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
<form action="index.php?option=com_booking&view=formules" method="post" id="adminForm" name="adminForm">
	<table class="table table-striped table-hover">
		<thead>
		<tr>
            <th width="1%"><?php echo JText::_('COM_BOOKING_NUM'); ?></th>
            <th width="2%">
                <?php echo JHtml::_('grid.checkall'); ?>
            </th>
            <th width="30%">
                <?php echo JText::_('COM_BOOKING_FORMULE_NAME') ;?>
            </th>
            <th width="30%">
                <?php echo JText::_('COM_BOOKING_FORMULE_MAX_ALLOWED_PERSON') ;?>
            </th>
            <th width="30%">
                <?php echo JText::_('COM_BOOKING_FORMULE_PRICE') ;?>
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
							<a href="<?php echo JRoute::_('index.php?option=com_booking&task=formule.edit&id=' . $row->id); ?>" title="<?php echo JText::_('COM_BOOKING_PERIOD_EDIT'); ?>">
								<?php echo $row->name; ?>
							</a>
						</td>
						<td>
							<?php echo $row->max_person_allowed; ?>
						</td>
                        <td>
                            <?php echo $row->price; ?>
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
