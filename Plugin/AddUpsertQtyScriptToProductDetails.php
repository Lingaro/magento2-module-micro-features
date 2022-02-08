<?php

/**
 * @copyright Copyright © 2022 Orba Sp. z o.o. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Plugin;

use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\LayoutInterface;
use Orba\MicroFeatures\ViewModel\UpsertQtyInitializer;

class AddUpsertQtyScriptToProductDetails
{
    private LayoutInterface $layout;
    private UpsertQtyInitializer $viewModel;

    public function __construct(LayoutInterface $layout, UpsertQtyInitializer $viewModel)
    {
        $this->layout = $layout;
        $this->viewModel = $viewModel;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetProductDetailsHtml(AbstractProduct $subject, string $result, Product $product): string
    {
        $this->viewModel->setProduct($product);
        if (!$this->viewModel->isEnabled()) {
            return $result;
        }
        $block = $this->layout->createBlock(
            Template::class,
            'upsert_qty_' . uniqid(),
            [
                'data' => [
                    'view_model' => $this->viewModel
                ]
            ]
        );
        $block->setTemplate('Orba_MicroFeatures::upsert_qty/list.phtml');
        return $result . $block->toHtml();
    }
}
