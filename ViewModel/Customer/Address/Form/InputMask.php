<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\ViewModel\Customer\Address\Form;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Orba\MicroFeatures\Model\Config;

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
