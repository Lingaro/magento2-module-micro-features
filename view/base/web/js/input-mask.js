/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

define([
    'jquery',
    'Orba_MicroFeatures/js/vendor/jquery.inputmask',
    'Orba_MicroFeatures/js/validation/input-mask'
], function ($) {
    'use strict';

    return function (config, element) {
        $(element).inputmask(config);
    };
});
