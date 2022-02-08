/**
 * @copyright Copyright © 2022 Orba. All rights reserved.
 * @author    info@orba.co
 */

define([
    'jquery',
    'Orba_MicroFeatures/js/upsert-qty/widget'
], function ($) {
    'use strict';

    return function (config) {
        var wrapper = $('<div>').addClass(config.wrapperClass);
        $(document).ready(function () {
            $(config.targetSelector).each(function () {
                var $this = $(this);
                $this.wrap(wrapper);
                var parent = $this.parent();
                $this.remove();
                var widgetConfig = config.widgetConfig;
                parent.upsertQty(widgetConfig);
            });
        });
    };
});
