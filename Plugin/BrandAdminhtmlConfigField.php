<?php

/**
 * @copyright Copyright © 2021 Orba Sp. z o.o. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Plugin;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\View\Asset\Repository;
use Orba\MicroFeatures\Model\System\Config\BrandProvider;

class BrandAdminhtmlConfigField
{
    private BrandProvider $brandProvider;
    private Repository $assetRepository;

    public function __construct(BrandProvider $brandProvider, Repository $assetRepository)
    {
        $this->brandProvider = $brandProvider;
        $this->assetRepository = $assetRepository;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterRender(Field $subject, string $result, AbstractElement $element): string
    {
        $fieldConfig = $element->getData('field_config');
        if (array_key_exists('brand', $fieldConfig)) {
            $brand = $this->brandProvider->get($fieldConfig['brand']);
            $result = str_replace(
                '<span data-config-scope=',
                $this->getLogoHtml(
                    $this->assetRepository->getUrl($brand->getLogo())
                ) . '<span data-config-scope=',
                $result
            );
        }
        return $result;
    }

    private function getLogoHtml(string $url): string
    {
        return '<img src="' . $url . '" style="height: 15px; margin-right: 10px; position: relative; top: 2px;" />';
    }
}
