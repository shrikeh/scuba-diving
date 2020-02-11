<?php

declare(strict_types=1);

namespace App\Kit\Model\Manufacturer;

use App\Kit\Model\ModelInterface;

interface ManufacturerInterface extends ModelInterface
{
    /**
     * @return string
     */
    public function getName(): string;
}
