
/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

define([], function () {
    'use strict';

    var checkoutConfig = window.checkoutConfig,
        microFeaturesConfig = checkoutConfig ? (checkoutConfig.orbaMicroFeatures || {}) : {};

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
