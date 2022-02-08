<?php

/**
 * @copyright Copyright © 2021 Orba Sp. z o.o. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Model\System\Config;

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
