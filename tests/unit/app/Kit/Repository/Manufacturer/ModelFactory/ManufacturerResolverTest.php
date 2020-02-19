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

use App\Kit\Model\Manufacturer\Decorator\ClosureResolver;
use App\Kit\Repository\Manufacturer\ModelFactory\ManufacturerResolver;
use App\Kit\Repository\ResolverFactory\ResolverFactoryInterface;
use App\Kit\Resolver\ResolverInterface;
use PHPUnit\Framework\TestCase;
use Shrikeh\Diving\Kit\Item\ItemSlug;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ManufacturerResolverTest extends TestCase
{
    public function testItCreatesAResolverDecorator(): void
    {
        $resolverFactory = $this->prophesize(ResolverFactoryInterface::class);
        $response = $this->prophesize(ResponseInterface::class)->reveal();
        $resolver = $this->prophesize(ResolverInterface::class)->reveal();
        $itemSlug = new ItemSlug('some-wetsuit');

        $resolverFactory->createResolver($response, $itemSlug->toUuid())->willReturn($resolver);

        $manufacturerResolver = new ManufacturerResolver(
            $resolverFactory->reveal()
        );

        $decorator = $manufacturerResolver->createManufacturerFromResponse($response, $itemSlug);

        $this->assertInstanceOf(ClosureResolver::class, $decorator);
    }
}
