<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\MicroFeatures\ViewModel\Customer\Address\Form;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Lingaro\MicroFeatures\Model\Config;

class InputMask implements ArgumentInterface
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getTelephoneInputMask(): string
    {
        return $this->config->getTelephoneInputMask();
    }

    public function getPostcodeInputMask(): string
    {
        return $this->config->getPostcodeInputMask();
    }
}
