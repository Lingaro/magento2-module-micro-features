/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
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
        'orba-input-mask-complete',
        function (value, element) {
            return value === '' || $(element).inputmask("isComplete");
        },
        $t("Value is incomplete")
    );

    validator.addRule(
        'orba-input-mask-complete',
        function (value, params) {
            return value === '' || $(params.selector).inputmask("isComplete");
        },
        $t("Value is incomplete")
    )
});
