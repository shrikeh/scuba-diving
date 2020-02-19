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

namespace App\Kit\Resolver;

use App\Kit\Model\ModelInterface;
use App\Kit\Resolver\Cache\Exception\InvalidCacheArgument;
use App\Kit\Resolver\Exception\ModelNotResolved;
use Closure;
use Ramsey\Uuid\UuidInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Throwable;

final class Cache implements ResolverInterface
{
    /**
     * @var CacheInterface
     */
    private CacheInterface $pool;

    /**
     * @var Closure
     */
    private Closure $callback;

    /**
     * @var UuidInterface
     */
    private UuidInterface $modelKey;

    /**
     * Cache constructor.
     *
     * @param CacheInterface $pool
     * @param Closure        $callback
     * @param UuidInterface  $modelKey
     */
    public function __construct(CacheInterface $pool, Closure $callback, UuidInterface $modelKey)
    {
        $this->pool = $pool;
        $this->callback = $callback;
        $this->modelKey = $modelKey;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidCacheArgument
     */
    public function __invoke(): ModelInterface
    {
        try {
            $model = $this->pool->get($this->modelKey->toString(), $this->callback);
        } catch (Throwable $e) {
            throw InvalidCacheArgument::create($this->modelKey, $e);
        }

        $this->assertModel($model);

        return $model;
    }

    /**
     * @param mixed $resolved
     * @psalm-assert ModelInterface $model
     */
    private function assertModel($resolved): void
    {
        if (!$resolved instanceof ModelInterface) {
            throw ModelNotResolved::fromResolved($resolved, ModelInterface::class);
        }
    }
}
