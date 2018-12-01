const Booking = function(
    mainControllerUrl,
    htmlContainerId,
    htmlOverviewContainerId,
    htmlErrorContainerId,
    formuleId,
    locale
) {
    this.mainControllerUrl = mainControllerUrl;
    this.htmlContainerId = htmlContainerId;
    this.htmlOverviewContainerId = htmlOverviewContainerId;
    this.htmlErrorContainerId = htmlErrorContainerId;
    this.formuleId = formuleId;
    this.howmuch = 0;
    this.date = null;
    this.period = null;
    this.currentStep = 0;
    this.finalData = null;
    this.locale = locale || 'fr-FR';

    jQuery('#booking-map-link').click(function(event) {
        event.preventDefault();
        jQuery('#booking-map').toggle();
    });

    jQuery('#save-step').click(function (event) {
        event.preventDefault();
        this.cleanErrors();
        this.nextStep();
    }.bind(this));

    jQuery('#cancel-step').click(function (event) {
        event.preventDefault();
        this.cleanErrors();
        this.previousStep();
    }.bind(this));
}

jQuery.extend(Booking.prototype, {
    previousStep: function() {
        this.currentStep-=2;
        this.loadStep();
    },
    nextStep: function() {
        this.currentStep++;
        this.loadStep();
    },
    loadStep: function() {

        switch (this.currentStep) {
            case 0: // load how nbr person would particapeted
                jQuery('#cancel-step').css('display', 'none');
                this.initStepNbrPerson();
                break;
            case 1: // save how much
                this.initStepSaveHowmuch();
                break;
            case 2: // load step date
                jQuery('#cancel-step').css('display', 'block');
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
                jQuery('#save-step').css('display', 'none');
                jQuery('#cancel-step').css('display', 'none');
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
            this.setContainerOverviewContent(result.overview_html);
            this.setContainerContent(result.html);
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
            this.setContainerOverviewContent(result.overview_html);
            const availableDate = result.available_date || [];
            /**
             * @todo delete me before deployment and after test
             */
            // console.log(availableDate);
            let options = {
                beforeShowDay: function(date){
                    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                    return [ availableDate.indexOf(string) !== -1 ];
                }
            };
            jQuery.extend(options, jQuery.datepicker.regional[this.locale]);
            jQuery("#datepicker").datepicker(options);
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
            this.setContainerOverviewContent(result.overview_html);
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
            } else {
                this.period = result.period;
                this.nextStep();
            }
        }.bind(this));
    },
    initStepForm: function() {
        const data = {
            'formule_id':this.formuleId,
            'howmuch':this.howmuch,
            'date':this.date,
            'period':this.period
        };

        this.ajaxCall('form', data, function (result) {
            this.setContainerContent(result.html);
            this.setContainerOverviewContent(result.overview_html);
            if (this.finalData !== null) {
                jQuery('#firstname').val(this.finalData.firstname);
                jQuery('#lastname').val(this.finalData.lastname);
            }
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
            this.setContainerContent(result.html);
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
    setContainerOverviewContent: function (content) {
        jQuery('#' + this.htmlOverviewContainerId).html(content);
    },
    cleanErrors:function () {
        jQuery('#' + this.htmlErrorContainerId).html("");
    },
    addErrors:function (errors) {
        jQuery('#' + this.htmlErrorContainerId).html(errors);
    }
});
