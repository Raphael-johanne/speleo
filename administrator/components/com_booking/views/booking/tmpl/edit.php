<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

?>

<form action="<?php echo JRoute::_('index.php?option=com_booking&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_BOOKING_BOOKING_DETAILS'); ?></legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <?php if (!empty($this->bookers)) : ?>
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_BOOKING_BOOKING_BOOKERS'); ?></legend>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="actions" id="actions-th1">
                        <span class="acl-action"><?php echo JText::_('COM_BOOKING_BOOKING_NBR_PERSON'); ?></span>
                    </th>
                    <th class="actions" id="actions-th1">
                        <span class="acl-action"><?php echo JText::_('COM_BOOKING_BOOKING_FIRSTNAME'); ?></span>
                    </th>
                    <th class="actions" id="actions-th1">
                        <span class="acl-action"><?php echo JText::_('COM_BOOKING_BOOKING_LASTNAME'); ?></span>
                    </th>
                    <th class="actions" id="actions-th1">
                        <span class="acl-action"><?php echo JText::_('COM_BOOKING_BOOKING_EMAIL'); ?></span>
                    </th>
                    <th class="actions" id="actions-th1">
                        <span class="acl-action"><?php echo JText::_('COM_BOOKING_BOOKING_PHONE'); ?></span>
                    </th>
                    <th class="actions" id="actions-th1">
                        <span class="acl-action"><?php echo JText::_('COM_BOOKING_BOOKING_IP'); ?></span>
                    </th>
                    <th class="actions" id="actions-th1">
                        <span class="acl-action"><?php echo JText::_('COM_BOOKING_BOOKING_PRICE'); ?></span>
                    </th>
                    <th class="actions" id="actions-th1">
                        <span class="acl-action"><?php echo JText::_('COM_BOOKING_BOOKING_ADDRESS'); ?></span>
                    </th>
                    <th class="actions" id="actions-th1">
                        <span class="acl-action"><?php echo JText::_('COM_BOOKING_BOOKING_ZIP_CODE'); ?></span>
                    </th>
                    <th class="actions" id="actions-th1">
                        <span class="acl-action"><?php echo JText::_('COM_BOOKING_BOOKING_COUNTRY'); ?></span>
                    </th>
                    <th class="actions" id="actions-th1">
                        <span class="acl-action"><?php echo JText::_('COM_BOOKING_BOOKING_IS_PRIVATE'); ?></span>
                    </th>
                    <th class="actions" id="actions-th1">
                        <span class="acl-action"><?php echo JText::_('COM_BOOKING_BOOKING_IS_COMFIRMED'); ?></span>
                    </th>
                    <th class="actions" id="actions-th1">
                        <span class="acl-action"><?php echo JText::_('COM_BOOKING_BOOKING_IS_CANCELED'); ?>d</span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($this->bookers as $booker):?>
                    <tr>
                        <td headers="actions-th1">
                            <label>
                                <?php echo $booker->nbr_person ?>
                            </label>
                        </td>
                        <td headers="actions-th1">
                            <label>
                                <?php echo $booker->firstname ?>
                            </label>
                        </td>
                        <td headers="actions-th1">
                            <label>
                                <?php echo $booker->lastname ?>
                            </label>
                        </td>
                        <td headers="actions-th1">
                            <label>
                                <?php echo $booker->email ?>
                            </label>
                        </td>
                        <td headers="actions-th1">
                            <label>
                                <?php echo $booker->phone ?>
                            </label>
                        </td>
                        <td headers="actions-th1">
                            <label>
                                <?php echo $booker->ip ?>
                            </label>
                        </td>
                        <td headers="actions-th1">
                            <label>
                                <?php echo $booker->price ?>
                            </label>
                        </td>
                        <td headers="actions-th1">
                            <label>
                                <?php echo $booker->address ?>
                            </label>
                        </td>
                        <td headers="actions-th1">
                            <label>
                                <?php echo $booker->zip_code ?>
                            </label>
                        </td>
                        <td headers="actions-th1">
                            <label>
                                <?php echo $booker->country ?>
                            </label>
                        </td>
                        <td headers="settings-th1">
                            <input <?php echo $booker->is_private == 1 ? "checked": "" ?> type="checkbox" name="bookers[<?php echo $booker->id?>][is_private]" />
                        </td>
                        <td headers="settings-th1">
                            <input <?php echo $booker->is_comfirmed == 1 ? "checked": "" ?> type="checkbox" name="bookers[<?php echo $booker->id?>][is_comfirmed]" />
                        </td>
                        <td headers="settings-th1">
                            <input <?php echo $booker->is_canceled == 1 ? "checked": "" ?> type="checkbox" name="bookers[<?php echo $booker->id?>][is_canceled]" />
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </fieldset>
    </div>
    <?php endif; ?>
    <input type="hidden" name="task" value="booking.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>
