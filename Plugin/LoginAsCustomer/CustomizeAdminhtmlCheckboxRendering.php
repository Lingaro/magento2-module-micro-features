<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\MicroFeatures\Plugin\LoginAsCustomer;

use Magento\Ui\Component\Form\Field;
use Lingaro\MicroFeatures\Model\Config;

class CustomizeAdminhtmlCheckboxRendering
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint
     */
    public function afterGetConfiguration(Field $subject, array $result): array
    {
        if ($subject->getName() === 'extension_attributes.assistance_allowed'
            && $subject->getContext()->getNamespace() === 'customer_form'
            && !$this->config->isShoppingAssistanceCheckboxNeeded()
        ) {
            $result['componentDisabled'] = true;
        }
        return $result;
    }
}
