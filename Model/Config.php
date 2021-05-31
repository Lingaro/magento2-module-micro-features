<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use function explode;

class Config
{
    const XML_PATH_PAYMENT_ACCOUNT_ADMIN_ONLY = 'payment/account/admin_only';
    const XML_PATH_LOGIN_AS_CUSTOMER_GENERAL_SHOPPING_ASSISTANCE_CHECKBOX_NEEDED
        = 'login_as_customer/general/shopping_assistance_checkbox_needed';

    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getAdminOnlyPaymentMethods(): array
    {
        $value = $this->scopeConfig->getValue(static::XML_PATH_PAYMENT_ACCOUNT_ADMIN_ONLY);
        if (empty($value)) {
            return [];
        }
        return explode(',', $value);
    }

    public function isShoppingAssistanceCheckboxNeeded(): bool
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_LOGIN_AS_CUSTOMER_GENERAL_SHOPPING_ASSISTANCE_CHECKBOX_NEEDED
        );
    }
}
