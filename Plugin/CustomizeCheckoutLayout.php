<?php

/**
 * @copyright Copyright © 2021 Orba Sp. z o.o. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Plugin;

use Magento\Checkout\Block\Checkout\LayoutProcessor;
use Magento\Checkout\Helper\Data as CheckoutHelper;
use Orba\MicroFeatures\Model\Config;

class CustomizeCheckoutLayout
{
    private Config $config;
    private CheckoutHelper $checkoutHelper;

    public function __construct(Config $config, CheckoutHelper $checkoutHelper)
    {
        $this->config = $config;
        $this->checkoutHelper = $checkoutHelper;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint
     */
    public function afterProcess(LayoutProcessor $subject, array $result): array
    {
        $result = $this->setFieldInputMask('telephone', $this->config->getTelephoneInputMask(), $result);
        $result = $this->setFieldInputMask('postcode', $this->config->getPostcodeInputMask(), $result);
        return $result;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint
     */
    private function setFieldInputMask(string $field, string $mask, array $jsLayout): array
    {
        if (!$mask) {
            return $jsLayout;
        }

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children'][$field]['config']
        ['inputMask']['mask'] = $mask;
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children'][$field]['validation']
        ['orba-input-mask-complete']['selector'] = '[name="shippingAddress.' . $field . '"] [name="' . $field . '"]';

        if ($this->checkoutHelper->isDisplayBillingOnPaymentMethodAvailable()) {
            if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
                ['payment']['children']['payments-list']['children'])) {
                foreach (array_keys($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
                         ['children']['payment']['children']['payments-list']['children']) as $key) {
                    if (substr($key, -5) !== '-form') {
                        continue;
                    }
                    $methodCode = substr($key, 0, -5);
                    if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
                        ['children']['payment']['children']['payments-list']['children'][$key]['children']
                        ['form-fields']['children'][$field])
                    ) {
                        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
                        ['children']['payment']['children']['payments-list']['children'][$key]['children']
                        ['form-fields']['children'][$field]['config']['inputMask']['mask'] = $mask;
                        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
                        ['children']['payment']['children']['payments-list']['children'][$key]['children']
                        ['form-fields']['children'][$field]['validation']['orba-input-mask-complete']['selector']
                            = '[name="billingAddress' . $methodCode . '.' . $field . '"] [name="' . $field . '"]';
                    }
                }
            }
            return $jsLayout;
        }

        if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['afterMethods']['children']['billing-address-form'])) {
            $methodCode = 'shared';
            if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
                ['payment']['children']['afterMethods']['children']['billing-address-form']['children']
                ['form-fields']['children'][$field])
            ) {
                $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
                ['payment']['children']['afterMethods']['children']['billing-address-form']['children']
                ['form-fields']['children'][$field]['config']['inputMask']['mask'] = $mask;
                $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
                ['payment']['children']['afterMethods']['children']['billing-address-form']['children']
                ['form-fields']['children'][$field]['validation']['orba-input-mask-complete']
                ['selector'] = '[name="billingAddress' . $methodCode . '.' . $field . '"] [name="' . $field . '"]';
            }
        }

        return $jsLayout;
    }
}
