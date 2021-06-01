<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Plugin\ProductCompare;

use Magento\Catalog\Block\Product\View\AddTo\Compare;

class CustomizeButtonRenderingOnProductView
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
