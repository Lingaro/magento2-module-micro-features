/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

define(['jquery'], function ($) {
    'use strict';

    var mixin = {
        initialize: function () {
            this._super();
            if (this.inputMask) {
                require([
                    'Magento_Ui/js/lib/view/utils/async',
                    'Lingaro_MicroFeatures/js/vendor/jquery.inputmask',
                    'Lingaro_MicroFeatures/js/validation/input-mask'
                ], this.inputMaskHandle.bind(this));
            }

            return this;
        },
        inputMaskHandle: function ($) {
            $.async(
                'input',
                this,
                this.afterElementRender.bind(this)
            );
        },
        afterElementRender: function (input) {
            $(input).inputmask(this.inputMask);
        }
    };

    return function (targetComponent) {
        return targetComponent.extend(mixin);
    }
});
