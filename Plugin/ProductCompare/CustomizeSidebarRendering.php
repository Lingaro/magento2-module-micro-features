<?php

/**
 * @copyright Copyright © 2021 Orba Sp. z o.o. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Plugin\ProductCompare;

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
