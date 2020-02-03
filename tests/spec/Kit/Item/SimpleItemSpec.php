<?php

declare(strict_types=1);

namespace spec\Shrikeh\Diving\Kit\Item;

use PhpSpec\ObjectBehavior;
use Shrikeh\Diving\Kit\Manufacturer;

final class SimpleItemSpec extends ObjectBehavior
{
    public function it_returns_the_name(): void
    {
        $manufacturer = new Manufacturer();
        $name = '5.5/6.5mm Delta Flex Semi-Tech Wetsuit';

        $this->beConstructedWith($name, $manufacturer);

        $this->getName()->shouldReturn($name);
    }

    public function it_returns_the_manufacturer(): void
    {
        $name = '5.5/6.5mm Delta Flex Semi-Tech Wetsuit';
        $manufacturer = new Manufacturer();

        $this->beConstructedWith($name, $manufacturer);

        $this->getManufacturer()->shouldReturn($manufacturer);
    }
}
