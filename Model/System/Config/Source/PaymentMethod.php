<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Model\System\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Payment\Helper\Data as PaymentHelper;

class PaymentMethod implements OptionSourceInterface
{
    private PaymentHelper $paymentHelper;

    public function __construct(PaymentHelper $paymentHelper)
    {
        $this->paymentHelper = $paymentHelper;
    }

    public function toOptionArray(): array
    {
        return $this->paymentHelper->getPaymentMethodList(true, true, true);
    }
}
