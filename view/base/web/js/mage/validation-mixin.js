/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

define([
    'jquery',
    'jquery/ui',
    'jquery/validate'
], function ($) {
    'use strict';

    var mixin = {
        _create: function () {
            this._super();
            $(this.element).triggerHandler('mage.validation:initialized');
        }
    };

    return function (targetWidget) {
        // Fix for jquery.validator not checking form fields with same name (eg. street[])
        $.validator.prototype.checkForm = function() {
            this.prepareForm();
            for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
                if (this.findByName(elements[i].name).length !== undefined && this.findByName(elements[i].name).length > 1) {
                    for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                        this.check(this.findByName(elements[i].name)[cnt]);
                    }
                } else {
                    this.check(elements[i]);
                }
            }
            return this.valid();
        };

        $.widget('mage.validation', targetWidget, mixin);

        return $.mage.validation;
    }
});
