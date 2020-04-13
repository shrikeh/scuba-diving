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

namespace Tests\Unit\App\Kit\Repository\Item\ModelFactory;

use App\Kit\Model\Item\Decorator\ClosureResolver;
use App\Kit\Repository\Item\ModelFactory\ItemResolver;
use App\Kit\Repository\ResolverFactory\ResolverFactoryInterface;
use App\Kit\Resolver\ResolverInterface;
use PHPUnit\Framework\TestCase;
use Shrikeh\Diving\Kit\Item\ItemSlug;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ItemResolverTest extends TestCase
{
    public function testItCreatesAResolverDecorator(): void
    {
        $resolverFactory = $this->prophesize(ResolverFactoryInterface::class);
        $response = $this->prophesize(ResponseInterface::class)->reveal();
        $resolver = $this->prophesize(ResolverInterface::class)->reveal();
        $itemSlug = new ItemSlug('some-wetsuit');

        $resolverFactory->createResolver($response, $itemSlug->toUuid())->willReturn($resolver);

        $itemResolver = new ItemResolver(
            $resolverFactory->reveal()
        );

        $decorator = $itemResolver->createItemFromResponse($response, $itemSlug);

        $this->assertInstanceOf(ClosureResolver::class, $decorator);
    }
}
