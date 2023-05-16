/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

var config = {
    "map": {
        "*": {
            "lingaro/inputMask": "Lingaro_MicroFeatures/js/input-mask",
            "lingaro/validationAdder": "Lingaro_MicroFeatures/js/validation-adder"
        }
    },
    "config": {
        "mixins": {
            "Magento_Ui/js/form/element/abstract": {
                "Lingaro_MicroFeatures/js/form/element/abstract-mixin": true
            },
            "mage/validation": {
                "Lingaro_MicroFeatures/js/mage/validation-mixin": true
            }
        }
    }
}
