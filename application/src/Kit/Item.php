<?php

declare(strict_types=1);

namespace Shrikeh\Diving\Kit;

interface Item
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return Manufacturer
     */
    public function getManufacturer(): Manufacturer;
}
