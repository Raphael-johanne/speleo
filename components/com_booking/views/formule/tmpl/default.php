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
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

<?php echo $this->item->get('name') ?>

<?php echo $this->item->get('price') ?>

<div id="errors">&nbsp;</div>

<div id="booking">&nbsp;</div>

<script type="application/javascript">

    const Booking = function(
        mainControllerUrl,
        htmlContainerId,
        htmlErrorContainerId,
        formuleId
    ) {
        this.mainControllerUrl = mainControllerUrl;
        this.htmlContainerId = htmlContainerId;
        this.htmlErrorContainerId = htmlErrorContainerId;
        this.formuleId = formuleId;
        this.howmuch = 0;
        this.date = null;
        this.period = null;
        this.currentStep = 0;
        this.finalData = null;
    }

    jQuery.extend(Booking.prototype, {
        previousStep: function() {
            this.currentStep--;
            this.loadStep();
        },
        nextStep: function() {
            this.currentStep++;
            this.cleanErrors();
            this.loadStep();
        },
        loadStep: function() {

            switch (this.currentStep) {
                case 0: // load how nbr person would particapeted
                    this.initStepNbrPerson();
                    break;
                case 1: // save how much
                    this.initStepSaveHowmuch();
                    break;
                case 2: // load step date
                    this.initStepDate();
                    break;
                case 3: // save date
                    this.initStepSaveDate();
                    break;
                case 4: // load available period for date
                    this.initStepPeriod();
                    break;
                case 5: // save available period for date
                    this.initStepSavePeriod();
                    break;
                case 6: // load subscribe formulary
                    this.initStepForm();
                    break;
                case 7: // save subscribe formulary
                    this.initStepSaveForm();
                    break;
                case 8: // end of subscription
                    this.initStepSuccess();
                    break;
                default: // load 0 = reinit
                {
                   this.currentStep = 0;
                   this.loadStep();
                }
            }
        },
        initStepNbrPerson: function() {
            const data = {
                'formule_id':this.formuleId
            };

            this.ajaxCall('howmuch', data, function (result) {
                this.setContainerContent(result.html);
                jQuery('#howmuch-save').click(function (event) {
                    event.preventDefault();
                    this.nextStep();
                }.bind(this));
            }.bind(this));
        },
        initStepSaveHowmuch: function() {
            const data = {
                'formule_id':this.formuleId,
                'howmuch':jQuery('#howmuch').val()
            };

            this.ajaxCall('savehowmuch', data, function (result) {
                if (result.errors.length > 0) {
                    this.addErrors(result.errors);
                    this.previousStep();
                } else {
                    this.howmuch = result.howmuch;
                    this.nextStep();
                }
            }.bind(this));
        },
        initStepDate: function() {
            const data = {
                'formule_id':this.formuleId,
                'howmuch':this.howmuch
            };

            this.ajaxCall('date', data, function (result) {
                this.setContainerContent(result.html);
                const unavailableDate = result.unavailable_date || [];

                jQuery( "#datepicker" ).datepicker({
                    beforeShowDay: function(date){
                        var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                        return [ unavailableDate.indexOf(string) == -1 ];
                    }
                });
                jQuery('#date-save').click(function (event) {
                    event.preventDefault();
                    this.nextStep();
                }.bind(this));
            }.bind(this));
        },
        initStepSaveDate: function() {
            const data = {
                'formule_id':this.formuleId,
                'howmuch':this.howmuch,
                'date':jQuery('#datepicker').val()
            };

            this.ajaxCall('savedate', data, function (result) {
                if (result.errors.length > 0) {
                    this.addErrors(result.errors);
                    this.previousStep();
                } else {
                    this.date = result.date;
                    this.nextStep();
                }
            }.bind(this));
        },
        initStepPeriod: function() {
            const data = {
                'formule_id':this.formuleId,
                'howmuch':this.howmuch,
                'date':this.date
            };

            this.ajaxCall('period', data, function (result) {
                this.setContainerContent(result.html);

                jQuery('#period-save').click(function (event) {
                    event.preventDefault();
                    this.nextStep();
                }.bind(this));
            }.bind(this));
        },
        initStepSavePeriod: function() {
            const data = {
                'formule_id':this.formuleId,
                'howmuch':this.howmuch,
                'date':this.date,
                'period':jQuery('#period').val()
            };

            this.ajaxCall('saveperiod', data, function (result) {
                if (result.errors.length > 0) {
                    this.addErrors(result.errors);
                    this.previousStep();
                } else {
                    this.period = result.period;
                    this.nextStep();
                }
            }.bind(this));
        },
        initStepForm: function() {
            const data = {
                'formule_id':this.formuleId,
                'howmuch' : this.howmuch,
                'date':this.date,
                'period':this.period
            };

            this.ajaxCall('form', data, function (result) {
                this.setContainerContent(result.html);
                if (this.finalData !== null) {
                    jQuery('#firstname').val(this.finalData.firstname);
                    jQuery('#lastname').val(this.finalData.lastname);
                }
                jQuery('#form-save').click(function (event) {
                    event.preventDefault();
                    this.nextStep();
                }.bind(this));
            }.bind(this));
        },
        initStepSaveForm: function() {
            this.finalData = {
                'formule_id':this.formuleId,
                'howmuch':this.howmuch,
                'date':this.date,
                'period':this.period,
                'firstname' : jQuery('#firstname').val(),
                'lastname' : jQuery('#lastname').val(),
                'email' : jQuery('#email').val(),
                'phone' : jQuery('#phone').val()
            };

            this.ajaxCall('saveform', this.finalData, function (result) {
                if (result.errors.length > 0) {
                    this.addErrors(result.errors);
                    this.previousStep();
                } else {
                    this.nextStep();
                }
            }.bind(this));
        },
        initStepSuccess: function() {
            const data = {
                'formule_id':this.formuleId,
                'howmuch':this.howmuch,
                'date':this.date,
                'period':this.period
            };

            this.ajaxCall('success', data, function (result) {
                if (result.errors.length > 0) {
                    this.addErrors(result.errors);
                } else {
                    this.setContainerContent(result.html);
                }
            }.bind(this));
        },
        ajaxCall: function(action, params, callback){
            jQuery.ajax({
                url: this.mainControllerUrl + '&task=booking.' + action,
                data: params,
                success: function(result) {
                    callback(result);
                }
            });
        },
        setContainerContent: function (content) {
            jQuery('#' + this.htmlContainerId).html(content);
        },
        cleanErrors:function () {
            jQuery('#' + this.htmlErrorContainerId).html("");
        },
        addErrors:function (errors) {
            jQuery('#' + this.htmlErrorContainerId).html(errors);
        }
    });

    const booking = new Booking(
        'index.php?option=com_booking',
        'booking',
        'errors',
        <?php echo $this->item->get('id') ?>);
    booking.loadStep();
</script>
