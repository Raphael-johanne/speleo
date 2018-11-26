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
JHtml::_('jquery.framework');
JHTML::stylesheet(Juri::base() . 'templates/booking/jquery-ui.multidatespicker.css');
JHtml::script(Juri::base() . 'templates/booking/jqueryui.min.js');
JHtml::script(Juri::base() . 'templates/booking/jquery-ui.multidatespicker.js');
?>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
<form action="<?php echo JRoute::_('index.php?option=com_booking&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_BOOKING_FORMULE_DETAILS'); ?></legend>
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
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_BOOKING_AVAILABLE_DATES'); ?></legend>
            <div class="row-fluid">
                <div id="booking-dates"></div>
                <input type="hidden" id="available-dates" name="available_dates" value="<?php echo implode(', ', $this->item->dates) ?>" />
            </div>
        </fieldset>
    </div>
    <?php if ($this->item->id > 0) : ?>
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
        <?php 
        $editor =& JFactory::getEditor();
        $params = [
            'smilies'           => '1' ,
            'style'             => '1' ,  
            'layer'             => '1' , 
            'table'             => '1' ,
            'clear_entities'    => '1'
        ];

        foreach ($this->item->attributes as $locale => $fields): ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'locale_' . $locale, JText::_('COM_BOOKING_LOCALIZED', true) . ': ' .$locale); ?> 
                <?php foreach ($fields as $code => $value): ?>
                <div class="control-group ">
                    <label><?php echo JText::_('COM_BOOKING_LOCALIZED_' . strtoupper($code)) ?></label>
                    <?php echo $editor->display( 'attributes['. $locale . ']['. $code .']', $value, '400', '400', '20', '20', false, null, null, null, $params ) ?>
                </div>
                <?php endforeach; ?>
                <?php echo JHtml::_('bootstrap.endTab'); ?>   
        <?php endforeach; ?>
        <?php echo JHtml::_('bootstrap.endTabSet'); ?>
    <?php endif; ?>
    <input type="hidden" name="task" value="formule.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>
<script type="text/javaScript">
    jQuery('#booking-dates').multiDatesPicker({
        onSelect: function() {
            jQuery('#available-dates').val(jQuery('#booking-dates').multiDatesPicker('value'))
        },
        dateFormat: 'yy-mm-dd'
        <?php if (!empty($this->item->dates)) : ?>
        , addDates: [<?php echo '"'.implode('","', $this->item->dates).'"' ?>] 
        <?php endif; ?>
    });
</script>
