/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

define([
    'jquery',
    'Lingaro_MicroFeatures/js/vendor/jquery.inputmask',
    'Lingaro_MicroFeatures/js/validation/input-mask'
], function ($) {
    'use strict';

    return function (config, element) {
        $(element).inputmask(config);
    };
});
