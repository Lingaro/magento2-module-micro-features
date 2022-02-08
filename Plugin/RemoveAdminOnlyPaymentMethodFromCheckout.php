<?php

/**
 * @copyright Copyright © 2021 Orba Sp. z o.o. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Plugin;

use Magento\Payment\Model\Checks\CanUseCheckout;
use Magento\Payment\Model\MethodInterface;
use Magento\Quote\Model\Quote;
use Orba\MicroFeatures\Model\Config;

class RemoveAdminOnlyPaymentMethodFromCheckout
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundIsApplicable(
        CanUseCheckout $subject,
        callable $proceed,
        MethodInterface $paymentMethod,
        Quote $quote
    ): bool {
        if (in_array($paymentMethod->getCode(), $this->config->getAdminOnlyPaymentMethods())) {
            return false;
        }
        return $proceed($paymentMethod, $quote);
    }
}
