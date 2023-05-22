<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\MicroFeatures\Plugin\ProductCompare;

use Magento\Catalog\Block\Product\ProductList\Item\AddTo\Compare;

class CustomizeButtonRenderingOnProductList
{
    private ProceedPreventer $proceedPreventer;

    public function __construct(ProceedPreventer $proceedPreventer)
    {
        $this->proceedPreventer = $proceedPreventer;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundToHtml(Compare $subject, callable $proceed): string
    {
        return $this->proceedPreventer->run($proceed);
    }
}
