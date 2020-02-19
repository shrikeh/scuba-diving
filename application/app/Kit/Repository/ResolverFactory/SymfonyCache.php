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

namespace App\Kit\Repository\ResolverFactory;

use App\Kit\Resolver\Cache;
use App\Kit\Resolver\Cache\ModelCallback;
use App\Kit\Resolver\ResolverInterface;
use Closure;
use DateInterval;
use Ramsey\Uuid\UuidInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class SymfonyCache implements ResolverFactoryInterface
{
    /**
     * @var ResolverFactoryInterface
     */
    private ResolverFactoryInterface $next;
    /**
     * @var CacheInterface
     */
    private $pool;
    /**
     * @var DateInterval
     */
    private $expiry;

    /**
     * SymfonyCache constructor.
     *
     * @param CacheInterface           $pool
     * @param ResolverFactoryInterface $next
     * @param DateInterval             $expiry
     */
    public function __construct(CacheInterface $pool, ResolverFactoryInterface $next, DateInterval $expiry)
    {
        $this->next = $next;
        $this->pool = $pool;
        $this->expiry = $expiry;
    }

    /**
     * @param ResponseInterface $response
     * @param UuidInterface     $uuid
     *
     * @return ResolverInterface
     */
    public function createResolver(ResponseInterface $response, UuidInterface $uuid): ResolverInterface
    {
        $nextClosure = Closure::fromCallable($this->next->createResolver($response, $uuid));

        return $this->createCacheWrapper($nextClosure, $uuid);
    }

    /**
     * @param Closure       $nextClosure
     * @param UuidInterface $uuid
     *
     * @return Cache
     */
    private function createCacheWrapper(Closure $nextClosure, UuidInterface $uuid): Cache
    {
        return new Cache(
            $this->pool,
            ModelCallback::asClosure($nextClosure, $this->expiry),
            $uuid
        );
    }
}
