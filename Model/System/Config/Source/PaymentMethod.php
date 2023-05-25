<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\MicroFeatures\Model\System\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Payment\Helper\Data as PaymentHelper;

class PaymentMethod implements OptionSourceInterface
{
    private PaymentHelper $paymentHelper;

    public function __construct(PaymentHelper $paymentHelper)
    {
        $this->paymentHelper = $paymentHelper;
    }

    /**
     * Returns payment methods in the following format: [['value' => '<value>', 'label' => '<label>'], ...]
     * @return array<int, array<string, string>>
     */
    public function toOptionArray(): array
    {
        return $this->paymentHelper->getPaymentMethodList(true, true, true);
    }
}
