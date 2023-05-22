/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

define([
    'jquery',
    'mage/translate',
    'Magento_Ui/js/lib/validation/validator',
    'jquery/ui',
    'jquery/validate'
], function($, $t, validator){
    'use strict';

    $.validator.addMethod(
        'lingaro-input-mask-complete',
        function (value, element) {
            return value === '' || $(element).inputmask("isComplete");
        },
        $t("Value is incomplete")
    );

    validator.addRule(
        'lingaro-input-mask-complete',
        function (value, params) {
            return value === '' || $(params.selector).inputmask("isComplete");
        },
        $t("Value is incomplete")
    )
});
