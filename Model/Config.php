<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use function explode;

class Config
{
    const XML_PATH_PAYMENT_ACCOUNT_ADMIN_ONLY = 'payment/account/admin_only';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getAdminOnlyPaymentMethods($websiteId = null): array
    {
        $value = $this->scopeConfig->getValue(
            static::XML_PATH_PAYMENT_ACCOUNT_ADMIN_ONLY,
            ScopeInterface::SCOPE_WEBSITE,
            $websiteId
        );
        if (empty($value)) {
            return [];
        }
        return explode(',', $value);
    }
}
