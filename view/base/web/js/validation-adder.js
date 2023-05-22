/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

define(['jquery', 'jquery/validate'], function ($) {
    'use strict';

    return function (config, element) {
        if (config.validate) {
            $(element.form).on('mage.validation:initialized', function () {
                $(element).rules('add', config.validate);
            });
        }
    };
});
