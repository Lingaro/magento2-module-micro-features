/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
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
