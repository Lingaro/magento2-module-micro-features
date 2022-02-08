<?php

/**
 * @copyright Copyright © 2022 Orba Sp. z o.o. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\ViewModel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Orba\MicroFeatures\Action\UpsertQuantity;
use Orba\MicroFeatures\Model\Config;

use function in_array;

class UpsertQtyInitializer implements ArgumentInterface
{
    private Json $serializer;
    private UrlInterface $url;
    private Config $config;
    private ?ProductInterface $product = null;

    public function __construct(Json $serializer, UrlInterface $url, Config $config)
    {
        $this->serializer = $serializer;
        $this->url = $url;
        $this->config = $config;
    }

    public function isEnabled(): bool
    {
        return $this->config->isUpsertQtyEnabled()
            && in_array($this->product->getTypeId(), UpsertQuantity::ALLOWED_PRODUCT_TYPES);
    }

    public function setProduct(ProductInterface $product): void
    {
        $this->product = $product;
    }

    public function getProduct(): ?ProductInterface
    {
        return $this->product;
    }

    public function getJsonConfig(string $targetSelector): string
    {
        return $this->serializer->serialize([
            'Orba_MicroFeatures/js/upsert-qty/widget-initializer' => [
                'targetSelector' => $targetSelector,
                'wrapperClass' => 'control orba-upsert-qty-wrapper',
                'widgetConfig' => [
                    'url' => $this->url->getUrl('orbaMicroFeatures/upsertQty'),
                    'addToCartButtonText' => __('Add to Cart'),
                    'updateCartButtonText' => __('Update Cart'),
                    'productType' => $this->product->getTypeId(),
                    'productId' => $this->product->getId(),
                    'sku' => $this->product->getSku()
                ]
            ]
        ]);
    }
}
