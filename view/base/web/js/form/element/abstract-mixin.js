/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

define(['jquery'], function ($) {
    'use strict';

    var mixin = {
        initialize: function () {
            this._super();
            if (this.inputMask) {
                require([
                    'Magento_Ui/js/lib/view/utils/async',
                    'Orba_MicroFeatures/js/vendor/jquery.inputmask',
                    'Orba_MicroFeatures/js/validation/input-mask'
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
