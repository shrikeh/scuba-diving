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

namespace Tests\Unit\App\Kit\Model\Item\Decorator;

use App\Api\ResponseParserInterface;
use App\Kit\Model\Exception\ModelNotResolved;
use App\Kit\Resolver\Response;
use App\Kit\Model\Exception\IncorrectModelResolved;
use App\Kit\Model\Item\Item;
use App\Kit\Model\Item\ItemInterface;
use App\Kit\Model\Item\Decorator\ClosureResolver;
use App\Kit\Model\Manufacturer\ManufacturerInterface;
use App\Kit\Model\ModelInterface;
use Closure;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;

use function json_decode;
use function json_encode;

final class ClosureResolverTest extends TestCase
{
    public function testItIsAModel(): void
    {
        $closure = Closure::fromCallable(static function () {
        });
        $item = ClosureResolver::create($closure);

        $this->assertInstanceOf(ModelInterface::class, $item);
    }

    public function testItReturnsTheName(): void
    {
        $name = 'Some sort of piece of kit';
        $item = new Item($name);

        $closure = Closure::fromCallable(static function () use ($item) {
            return $item;
        });

        $item = ClosureResolver::create($closure);

        $this->assertSame($name, $item->getName());
    }

    public function testItIsJsonSerializable(): void
    {
        $name = 'Some sort of piece of kit';
        $item = new Item($name);

        $closure = Closure::fromCallable(static function () use ($item) {
            return $item;
        });

        $item = ClosureResolver::create($closure);

        $json = json_decode(json_encode($item), false);

        $this->assertSame($name, $json->name);
    }

    public function testItThrowsAnIncorrectModelExceptionIfTheModelResolvedIsNotAnItem(): void
    {
        $manufacturer = $this->prophesize(ManufacturerInterface::class)->reveal();

        $closure = Closure::fromCallable(static function () use ($manufacturer) {
            return $manufacturer;
        });

        $item = ClosureResolver::create($closure);

        $this->expectExceptionObject(IncorrectModelResolved::fromModel($manufacturer, ItemInterface::class));

        $item->getName();
    }

    public function testItThrowsAModelNotResolvedExceptionIfItDoesNotResolveAModel(): void
    {
        $borked = new \stdClass();
        $closure = Closure::fromCallable(static function () use ($borked) {
            return $borked;
        });

        $item = ClosureResolver::create($closure);

        $this->expectExceptionObject(ModelNotResolved::create($closure, $borked));

        $item->getName();
    }

    public function testItCallsTheClosureOnlyOnce(): void
    {
        $item = $this->prophesize(ItemInterface::class);
        $item->getName()->willReturn('Promate');
        $response = $this->prophesize(ResponseInterface::class)->reveal();
        $parser = $this->prophesize(ResponseParserInterface::class);

        $parser->parse($response)->will(function () use ($parser, $response, $item) {
            $parser->parse($response)->shouldNotBeCalled();

            return $item->reveal();
        });

        $resolver = new Response($response, $parser->reveal());

        $item = ClosureResolver::create($resolver);

        $item->getName();
        $item->getName();

        $parser->parse($response)->shouldBeCalledOnce();
    }
}
