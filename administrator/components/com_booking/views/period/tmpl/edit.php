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
            <legend><?php echo JText::_('COM_BOOKING_PERIOD_EDIT'); ?></legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $field) : ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <?php if ($this->item->id > 0) : ?>
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
        <?php foreach ($this->item->attributes as $locale => $fields): ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'locale_' . $locale, JText::_('COM_BOOKING_LOCALIZED', true) . ': ' .$locale); ?> 
                <?php foreach ($fields as $code => $value): ?>
                <div class="control-group ">
                    <label><?php echo $code ?></label>
                    <textarea class="mceAdvanced" name="attributes[<?php echo $locale ?>][<?php echo $code ?>]"><?php echo $value ?></textarea>
                </div>
                <?php endforeach; ?>
                <?php echo JHtml::_('bootstrap.endTab'); ?>   
        <?php endforeach; ?>
        <?php echo JHtml::_('bootstrap.endTabSet'); ?>
    <?php endif; ?>
    <input type="hidden" name="task" value="period.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>
