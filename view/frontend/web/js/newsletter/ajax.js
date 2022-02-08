/**
 * @copyright Copyright © 2022 Orba. All rights reserved.
 * @author    info@orba.co
 */

define([
    'jquery',
    'mage/translate',
    'uiComponent',
    'Magento_Ui/js/modal/alert'
], function ($, $t, Component, alert) {
    'use strict';

    return Component.extend({

        defaults: {
            element: null,
            errorTitle: $t('An error occurred'),
            warningTitle: $t('Warning'),
            noticeTitle: $t('Notice'),
            successTitle: $t('Success'),
            errorMessage: $t('We are sorry, but an unexpected error occurred. Please try again later.')
        },

        initialize: function (config, element) {
            this._super(config, element);
            this.element = $(element);
            this.element.on('submit', this.onSubmit.bind(this));
        },

        onSubmit: function () {
            $.ajax({
                type: 'POST',
                url: this.element.attr('action'),
                data: this.element.serialize()
            })
            .done(this.onDone.bind(this))
            .fail(this.onFail.bind(this))
            .always(this.onAlways.bind(this));

            return false;
        },

        onDone: function (response) {
            var title = '';
            switch (response.type) {
                case 'error':
                    title = this.errorTitle;
                    break;
                case 'warning':
                    title = this.warningTitle;
                    break;
                case 'notice':
                    title = this.noticeTitle;
                    break;
                case 'success':
                    title = this.successTitle;
                    break;
            }
            alert({
                title: title,
                content: response.message
            });
        },

        onFail: function () {
            alert({
                title: this.errorTitle,
                content: this.errorMessage
            });
        },

        onAlways: function () {
            this.element.find(':submit').prop('disabled', false);
        }

    });
});
