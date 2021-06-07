/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

var config = {
    "map": {
        "*": {
            "orba/inputMask": "Orba_MicroFeatures/js/input-mask",
            "orba/validationAdder": "Orba_MicroFeatures/js/validation-adder"
        }
    },
    "config": {
        "mixins": {
            "Magento_Ui/js/form/element/abstract": {
                "Orba_MicroFeatures/js/form/element/abstract-mixin": true
            },
            "mage/validation": {
                "Orba_MicroFeatures/js/mage/validation-mixin": true
            }
        }
    }
}
