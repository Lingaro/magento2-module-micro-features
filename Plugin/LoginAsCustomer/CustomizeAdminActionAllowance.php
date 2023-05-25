<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\MicroFeatures\Plugin\LoginAsCustomer;

use Magento\LoginAsCustomerAssistance\Model\IsAssistanceEnabled;
use Lingaro\MicroFeatures\Model\Config;

class CustomizeAdminActionAllowance
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterExecute(IsAssistanceEnabled $subject, bool $result): bool
    {
        if ($this->config->isShoppingAssistanceCheckboxNeeded()) {
            return $result;
        }
        return true;
    }
}
