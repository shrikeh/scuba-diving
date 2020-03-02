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

namespace Tests\Unit\App\Kit\Repository\ResolverFactory;

use App\Kit\Model\ModelInterface;
use App\Kit\Repository\ResolverFactory\ResolverFactoryInterface;
use App\Kit\Repository\ResolverFactory\SymfonyCache;
use App\Kit\Resolver\Cache;
use App\Kit\Resolver\ResolverInterface;
use Closure;
use DateInterval;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class SymfonyCacheTest extends TestCase
{
    public function testItCreatesAResolver(): void
    {
        $uuid = $this->prophesize(UuidInterface::class)->reveal();
        $response = $this->prophesize(ResponseInterface::class)->reveal();
        $resolverFactory = $this->prophesize(ResolverFactoryInterface::class);
        $cache = $this->prophesize(CacheInterface::class);
        $resolver = $this->prophesize(ResolverInterface::class);
        $resolverFactory->createResolver($response, $uuid)->willReturn($resolver->reveal());
        $expiresAfter = new DateInterval('PT2S');

        $symfonyCacheFactory = new SymfonyCache($cache->reveal(), $resolverFactory->reveal(), $expiresAfter);

        $resolver = $symfonyCacheFactory->createResolver($response, $uuid);

        $this->assertInstanceOf(Cache::class, $resolver);
    }
}
