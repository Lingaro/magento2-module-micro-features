<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\MicroFeatures\Model\System\Config;

use InvalidArgumentException;

class BrandProvider
{
    /** @var Brand[] */
    private array $brands;

    /**
     * @param Brand[] $brands
     */
    public function __construct(array $brands = [])
    {
        foreach ($brands as $brand) {
            if (!$brand instanceof Brand) {
                throw new InvalidArgumentException('Brand must be an instance of ' . Brand::class);
            }
        }
        $this->brands = $brands;
    }

    public function get(string $code): Brand
    {
        if (!array_key_exists($code, $this->brands)) {
            throw new InvalidArgumentException('Brand "' . $code . '" is not defined.');
        }
        return $this->brands[$code];
    }
}
