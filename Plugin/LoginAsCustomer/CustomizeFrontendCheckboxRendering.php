<?php

/**
 * @copyright Copyright © 2021 Orba Sp. z o.o. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Plugin\LoginAsCustomer;

use Magento\LoginAsCustomerAssistance\ViewModel\ShoppingAssistanceViewModel;
use Orba\MicroFeatures\Model\Config;

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
