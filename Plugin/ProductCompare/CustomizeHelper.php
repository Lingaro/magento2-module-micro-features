<?php

/**
 * @copyright Copyright © 2021 Orba Sp. z o.o. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Plugin\ProductCompare;

use Magento\Catalog\Helper\Product\Compare;

class CustomizeHelper
{
    private ProceedPreventer $proceedPreventer;

    public function __construct(ProceedPreventer $proceedPreventer)
    {
        $this->proceedPreventer = $proceedPreventer;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundGetAddUrl(Compare $subject, callable $proceed): string
    {
        return $this->proceedPreventer->run($proceed);
    }
}
