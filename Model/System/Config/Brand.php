<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\MicroFeatures\Model\System\Config;

class Brand
{
    private string $logo;

    public function __construct(string $logo)
    {
        $this->logo = $logo;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }
}
