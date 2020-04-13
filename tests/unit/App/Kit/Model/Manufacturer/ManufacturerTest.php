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

namespace Tests\Unit\App\Kit\Model\Manufacturer;

use App\Kit\Model\Manufacturer\Manufacturer;
use JsonSerializable;
use PHPUnit\Framework\TestCase;

final class ManufacturerTest extends TestCase
{
    public function testItIsJsonSerializable(): void
    {
        $name = "O'Three";
        $manufacturer = new Manufacturer($name);

        $this->assertInstanceOf(JsonSerializable::class, $manufacturer);
        $this->assertSame(
            [Manufacturer::KEY_NAME => $name],
            $manufacturer->jsonSerialize()
        );
    }

    public function testItReturnsTheName(): void
    {
        $name = "O'Three";
        $manufacturer = new Manufacturer($name);

        $this->assertSame($name, $manufacturer->getName());
        $this->assertSame($name, (string) $manufacturer);
    }
}
