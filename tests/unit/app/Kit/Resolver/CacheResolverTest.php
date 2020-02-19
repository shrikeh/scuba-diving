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

namespace Tests\Unit\App\Kit\Resolver;

use App\Kit\Model\ModelInterface;
use App\Kit\Resolver\Cache;
use App\Kit\Resolver\Cache\Exception\InvalidCacheArgument;
use App\Kit\Resolver\Exception\ModelNotResolved;
use Closure;
use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;
use stdClass;
use Symfony\Contracts\Cache\CacheInterface;

final class CacheResolverTest extends TestCase
{
    public function testItThrowsAnExceptionIfTheCacheDoesNotReturnAModel(): void
    {
        $pool = $this->prophesize(CacheInterface::class);
        $callback = Closure::fromCallable(function () {
        });
        $uuid = Uuid::uuid4();
        $wrongResolution = new stdClass();

        $pool->get($uuid->toString(), $callback)->willReturn($wrongResolution);

        $resolver = new Cache($pool->reveal(), $callback, $uuid);

        $this->expectExceptionObject(ModelNotResolved::fromResolved(
            $wrongResolution,
            ModelInterface::class
        ));

        $resolver();
    }

    public function testItThrowsACacheExceptionIfThePoolThrowsAPsrException(): void
    {
        $pool = $this->prophesize(CacheInterface::class);
        $exception = new Exception('Foo');
        $callback = Closure::fromCallable(function () {
        });
        $uuid = Uuid::uuid4();

        $pool->get(Argument::cetera())->willThrow($exception);

        $resolver = new Cache($pool->reveal(), $callback, $uuid);

        $this->expectExceptionObject(InvalidCacheArgument::create($uuid, $exception));
        $this->expectExceptionCode(0);

        $resolver();
    }
}
