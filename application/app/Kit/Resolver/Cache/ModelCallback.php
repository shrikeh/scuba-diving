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

namespace App\Kit\Resolver\Cache;

use App\Kit\Model\ModelInterface;
use App\Kit\Resolver\Exception\ModelNotResolved;
use Closure;
use DateInterval;
use Symfony\Contracts\Cache\ItemInterface;

final class ModelCallback
{
    /**
     * @var Closure
     */
    private Closure $resolver;

    /**
     * @var DateInterval
     */
    private DateInterval $expiresAfter;

    /**
     * @param Closure $resolver
     * @param DateInterval $expiresAfter
     * @return Closure
     * @SuppressWarnings(PHPMD.StaticAccess) Named constructor pattern
     */
    public static function asClosure(Closure $resolver, DateInterval $expiresAfter): Closure
    {
        /** @SuppressWarnings(PHPMD.StaticAccess) Named constructor pattern */
        return Closure::fromCallable(new self($resolver, $expiresAfter));
    }

    /**
     * ModelCallback constructor.
     * @param Closure $resolver
     * @param DateInterval $expiresAfter
     */
    public function __construct(Closure $resolver, DateInterval $expiresAfter)
    {
        $this->resolver = $resolver;
        $this->expiresAfter = $expiresAfter;
    }

    /**
     * @param ItemInterface $item
     * @return ModelInterface
     * @throws ModelNotResolved If the resolver does not return a ModelInterface
     */
    public function __invoke(ItemInterface $item): ModelInterface
    {
        $resolver = $this->resolver;
        $model = $resolver();
        $this->assertModel($model);

        $item->expiresAfter($this->expiresAfter);

        return $model;
    }

    /**
     * @param mixed $model
     * @throws ModelNotResolved If the resolver does not return a ModelInterface
     */
    private function assertModel($model): void
    {
        if (!$model instanceof ModelInterface) {
            /** @SuppressWarnings(PHPMD.StaticAccess) Named constructor pattern */
            throw ModelNotResolved::fromResolved($model, ModelInterface::class);
        }
    }
}
