<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\MicroFeatures\Plugin\LoginAsCustomer;

use Magento\LoginAsCustomerAssistance\ViewModel\ShoppingAssistanceViewModel;
use Lingaro\MicroFeatures\Model\Config;

class CustomizeFrontendCheckboxRendering
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterIsLoginAsCustomerEnabled(ShoppingAssistanceViewModel $subject, bool $result): bool
    {
        if ($result) {
            return $this->config->isShoppingAssistanceCheckboxNeeded();
        }
        return false;
    }
}
