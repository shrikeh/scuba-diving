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

namespace Tests\Unit\App\Kit\Repository\Manufacturer\ModelFactory;

use App\Api\ResponseParserInterface;
use App\Kit\Model\Manufacturer\ManufacturerInterface;
use App\Kit\Model\Manufacturer\ResolverDecorator;
use App\Kit\Repository\Manufacturer\ModelFactory\SymfonyResponseManufacturerFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class SymfonyResponseManufacturerFactoryTest extends TestCase
{
    public function testItCreatesAResolverDecorator(): void
    {
        $responseParser = $this->prophesize(ResponseParserInterface::class);
        $response = $this->prophesize(ResponseInterface::class)->reveal();

        $symfonyResponseManufacturerFactory = new SymfonyResponseManufacturerFactory(
            $responseParser->reveal()
        );

        $decorator = $symfonyResponseManufacturerFactory->createManufacturerFromResponse($response);

        $this->assertInstanceOf(ResolverDecorator::class, $decorator);
    }

    public function testItUsesTheResponse(): void
    {
        $name = 'Foo';
        $responseParser = $this->prophesize(ResponseParserInterface::class);
        $manufacturer = $this->prophesize(ManufacturerInterface::class);
        $manufacturer->getName()->willReturn($name);

        $response = $this->prophesize(ResponseInterface::class)->reveal();

        $responseParser->parse($response)->willReturn($manufacturer->reveal());

        $symfonyResponseManufacturerFactory = new SymfonyResponseManufacturerFactory(
            $responseParser->reveal()
        );

        $decorator = $symfonyResponseManufacturerFactory->createManufacturerFromResponse($response);

        $this->assertSame($name, $decorator->getName());
    }
}
