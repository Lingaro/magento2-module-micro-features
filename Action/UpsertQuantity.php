<?php

/**
 * @copyright Copyright © 2022 Orba Sp. z o.o. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Action;

use Exception;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Type as ProductType;
use Magento\Checkout\Model\Cart;
use Magento\Downloadable\Model\Product\Type as DownloadableType;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Zend_Filter_LocalizedToNormalized;

class UpsertQuantity
{
    public const ALLOWED_PRODUCT_TYPES = [
        ProductType::TYPE_SIMPLE,
        ProductType::TYPE_VIRTUAL,
        DownloadableType::TYPE_DOWNLOADABLE
    ];

    private Cart $cart;
    private Escaper $escaper;
    private LoggerInterface $logger;
    private RequestInterface $request;
    private ProductRepositoryInterface $productRepository;
    private StoreManagerInterface $storeManager;
    private ResolverInterface $resolver;

    public function __construct(
        Cart $cart,
        Escaper $escaper,
        LoggerInterface $logger,
        RequestInterface $request,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager,
        ResolverInterface $resolver
    ) {
        $this->cart = $cart;
        $this->escaper = $escaper;
        $this->logger = $logger;
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        $this->resolver = $resolver;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
     */
    public function execute(): array
    {
        $result = ['success' => false];
        $params = $this->request->getParams();

        if (!isset($params['qty']) &&
            strlen($params['qty']) > 0 &&
            preg_match('/[^,.0-9]/', $params['qty'])) {
            return array_merge($result, [
                'message' => __('Invalid value provided.')
            ]);
        }

        $params = ['qty' => $this->normalize($params['qty'])];

        if ($params['qty'] < 0) {
            return array_merge($result, [
                'message' => __('Invalid value provided.')
            ]);
        }

        $product = $this->initProduct();
        if (!$product) {
            return array_merge($result, [
                'message' => __('Invalid product provided.')
            ]);
        }

        try {
            if (in_array($product->getId(), $this->cart->getProductIds())) {
                $this->cart->updateItems([
                    $this->cart->getQuote()->getItemByProduct($product)->getId() => $params
                ])->save();
                $result['success'] = true;
                return $result;
            }
            $this->addToCart($product, $params);
            $result['success'] = true;
            return $result;
        } catch (LocalizedException $e) {
            $result['message'] = $this->escaper->escapeHtml($e->getMessage());
        } catch (Exception $e) {
            $result['message'] = __('We cannot add or change this item in your shopping cart right now.');
            $this->logger->critical($e);
        }

        return $result;
    }

    private function initProduct():? Product
    {
        $productId = (int) $this->request->getParam('product');
        if ($productId) {
            try {
                /** @var Product $product */
                $product = $this->productRepository->getById(
                    $productId,
                    false,
                    $this->storeManager->getStore()->getId()
                );
                if (in_array($product->getTypeId(), self::ALLOWED_PRODUCT_TYPES)) {
                    return $product;
                }
            } catch (NoSuchEntityException $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     * @throws LocalizedException
     */
    private function addToCart(Product $product, array $params): void
    {
        $this->cart->addProduct($product, $params);
        $this->cart->save();
    }

    private function normalize(string $itemQty): string
    {
        return (new Zend_Filter_LocalizedToNormalized(['locale' => $this->resolver->getLocale()]))->filter($itemQty);
    }
}
