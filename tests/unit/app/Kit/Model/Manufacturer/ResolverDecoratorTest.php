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

use App\Api\ResponseParserInterface;
use App\Api\ResponseResolver\ResponseResolver;
use App\Kit\Model\Exception\IncorrectModelResolved;
use App\Kit\Model\Item\ItemInterface;
use App\Kit\Model\Manufacturer\Manufacturer;
use App\Kit\Model\Manufacturer\ManufacturerInterface;
use App\Kit\Model\Manufacturer\ResolverDecorator;
use App\Kit\Model\ModelInterface;
use Closure;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ResolverDecoratorTest extends TestCase
{
    public function testItIsAModel(): void
    {
        $closure = Closure::fromCallable(fn() => null);
        $manufacturer = ResolverDecorator::create($closure);

        $this->assertInstanceOf(ModelInterface::class, $manufacturer);
    }

    public function testItReturnsTheName(): void
    {
        $name = 'Some manufacturer';
        $manufacturer = new Manufacturer($name);

        $closure = Closure::fromCallable(fn() => $manufacturer);

        $manufacturer = ResolverDecorator::create($closure);

        $this->assertSame($name, $manufacturer->getName());
    }

    public function testItIsJsonSerializable(): void
    {
        $name = 'Some sort of piece of kit';
        $manufacturer = new Manufacturer($name);

        $closure = Closure::fromCallable(fn() => $manufacturer);

        $manufacturer = ResolverDecorator::create($closure);

        $json = json_decode(json_encode($manufacturer), false);

        $this->assertSame($name, $json->name);
    }

    public function testItThrowsAnIncorrectModelExceptionIfTheModelResolvedIsNotAManufacturer(): void
    {
        $item = $this->prophesize(ItemInterface::class)->reveal();

        $closure = Closure::fromCallable(fn() => $item);

        $manufacturer = ResolverDecorator::create($closure);

        $this->expectExceptionObject(IncorrectModelResolved::fromModel($item, ManufacturerInterface::class));

        $manufacturer->getName();
    }

    public function testItCallsTheClosureOnlyOnce(): void
    {
        $manufacturer = $this->prophesize(ManufacturerInterface::class);
        $manufacturer->getName()->willReturn('Promate');
        $response = $this->prophesize(ResponseInterface::class)->reveal();
        $parser = $this->prophesize(ResponseParserInterface::class);

        $parser->parse($response)->will(function () use ($parser, $response, $manufacturer) {
            $parser->parse($response)->shouldNotBeCalled();

            return $manufacturer->reveal();
        });

        $resolver = new ResponseResolver($response, $parser->reveal());

        $manufacturer = ResolverDecorator::create($resolver);

        $manufacturer->getName();
        $manufacturer->getName();

        $parser->parse($response)->shouldBeCalledOnce();
    }
}
