
/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

define([], function () {
    'use strict';

    var checkoutConfig = window.checkoutConfig,
        microFeaturesConfig = checkoutConfig ? (checkoutConfig.lingaroMicroFeatures || {}) : {};

    var mixin = {
        isItemsBlockExpanded: function () {
            if (microFeaturesConfig.itemsBlockExpandedByDefault) {
                return true;
            }
            return this._super();
        }
    };

    return function (targetComponent) {
        return targetComponent.extend(mixin);
    }
});
