/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

define([
    'jquery',
    'Lingaro_MicroFeatures/js/upsert-qty/widget'
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
