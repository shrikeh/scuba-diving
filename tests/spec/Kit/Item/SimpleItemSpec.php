<?php

/*
 * This file is part of the Diving Site package.
 *
 * (c) Barney Hanlon <barney@shrikeh.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace spec\Shrikeh\Diving\Kit\Item;

use PhpSpec\ObjectBehavior;
use Shrikeh\Diving\Kit\Manufacturer;

final class SimpleItemSpec extends ObjectBehavior
{
    public function it_returns_the_name(): void
    {
        $manufacturer = new Manufacturer('Northern Diver');
        $name = '5.5/6.5mm Delta Flex Semi-Tech Wetsuit';

        $this->beConstructedWith($name, $manufacturer);

        $this->getName()->shouldReturn($name);
    }

    public function it_returns_the_manufacturer(): void
    {
        $name = '5.5/6.5mm Delta Flex Semi-Tech Wetsuit';
        $manufacturer = new Manufacturer('Northern Diver');

        $this->beConstructedWith($name, $manufacturer);

        $this->getManufacturer()->shouldReturn($manufacturer);
    }
}
