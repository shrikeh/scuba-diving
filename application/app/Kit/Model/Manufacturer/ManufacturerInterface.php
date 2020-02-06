<?php

declare(strict_types=1);

namespace App\Kit\Model\Manufacturer;

use JsonSerializable;

interface ManufacturerInterface extends JsonSerializable
{
    /**
     * @return string
     */
    public function getName(): string;
}
