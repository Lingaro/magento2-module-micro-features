<?php

/**
 * @copyright Copyright © 2021 Orba Sp. z o.o. All rights reserved.
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

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     */
    public function getConfig(): array
    {
        return [
            'orbaMicroFeatures' => [
                'itemsBlockExpandedByDefault' => $this->config->shouldAlwaysExpandItemsBlockOnCheckout()
            ]
        ];
    }
}
