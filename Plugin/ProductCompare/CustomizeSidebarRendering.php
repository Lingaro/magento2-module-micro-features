<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\MicroFeatures\Plugin\ProductCompare;

use Magento\Framework\View\Element\Template;

class CustomizeSidebarRendering
{
    private ProceedPreventer $proceedPreventer;

    public function __construct(ProceedPreventer $proceedPreventer)
    {
        $this->proceedPreventer = $proceedPreventer;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundToHtml(Template $subject, callable $proceed): string
    {
        if ($subject->getNameInLayout() === 'catalog.compare.sidebar') {
            return $this->proceedPreventer->run($proceed);
        }
        return $proceed();
    }
}
