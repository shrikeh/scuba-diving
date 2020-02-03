<?php

declare(strict_types=1);

namespace Shrikeh\Diving\Kit\Item;

use Shrikeh\Diving\Kit\Manufacturer;

final class SimpleItem
{
    /**
     * @var string
     */
    private string $name;
    /**
     * @var Manufacturer
     */
    private $manufacturer;

    /**
     * SimpleItem constructor.
     * @param string $name
     * @param Manufacturer $manufacturer
     */
    public function __construct(string $name, Manufacturer $manufacturer)
    {
        $this->name = $name;
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Manufacturer
     */
    public function getManufacturer(): Manufacturer
    {
        return $this->manufacturer;
    }
}
