<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\MicroFeatures\Plugin\ProductCompare;

use Lingaro\MicroFeatures\Model\Config;

class ProceedPreventer
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function run(callable $proceed): string
    {
        if (!$this->config->isProductComparisonEnabled()) {
            return '';
        }
        return $proceed();
    }
}
