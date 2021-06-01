<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

class CheckoutConfigProvider implements ConfigProviderInterface
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getConfig(): array
    {
        return [
            'orbaMicroFeatures' => [
                'itemsBlockExpandedByDefault' => $this->config->shouldAlwaysExpandItemsBlockOnCheckout()
            ]
        ];
    }
}
