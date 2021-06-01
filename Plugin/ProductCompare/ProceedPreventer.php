<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Plugin\ProductCompare;

use Orba\MicroFeatures\Model\Config;

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
