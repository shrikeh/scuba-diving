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

namespace Tests\Unit\App\Kit\Query\Result;

use App\Kit\Model\Item\ItemInterface;
use App\Kit\Model\Manufacturer\ManufacturerInterface;
use App\Kit\Query\Result\SimpleItem;
use PHPUnit\Framework\TestCase;

final class SimpleItemTest extends TestCase
{
    public function testItReturnsTheName(): void
    {
        $name = 'My wonderful regulator';
        $item = $this->prophesize(ItemInterface::class);
        $manufactuer = $this->prophesize(ManufacturerInterface::class);

        $item->getName()->willReturn($name);

        $simpleItem = new SimpleItem(
            $item->reveal(),
            $manufactuer->reveal()
        );

        $this->assertSame($name, $simpleItem->getName());
    }

    public function testItReturnsTheManufacturerName(): void
    {
        $name = 'Apeks';
        $item = $this->prophesize(ItemInterface::class);
        $manufactuer = $this->prophesize(ManufacturerInterface::class);

        $manufactuer->getName()->willReturn($name);

        $simpleItem = new SimpleItem(
            $item->reveal(),
            $manufactuer->reveal()
        );

        $this->assertSame($name, $simpleItem->getManufacturerName());
    }
}
