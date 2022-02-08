<?php

/**
 * @copyright Copyright © 2021 Orba Sp. z o.o. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Plugin\LoginAsCustomer;

use Magento\LoginAsCustomerAssistance\Model\IsAssistanceEnabled;
use Orba\MicroFeatures\Model\Config;

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
