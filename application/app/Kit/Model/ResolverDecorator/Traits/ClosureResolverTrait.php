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

namespace App\Kit\Model\ResolverDecorator\Traits;

use App\Kit\Model\Exception\IncorrectModelResolved;
use App\Kit\Model\ModelInterface;
use Closure;

trait ClosureResolverTrait
{
    /**
     * @var ModelInterface
     */
    private ?ModelInterface $model;

    /**
     * @var Closure
     */
    private Closure $resolver;

    /**
     * @param callable $callable
     * @return mixed
     */
    public static function create(callable $callable)
    {
        if (!$callable instanceof Closure) {
            $callable = Closure::fromCallable($callable);
        }

        return new static($callable);
    }

    /**
     * ClosureResolverTrait constructor.
     * @param Closure $resolver
     */
    private function __construct(Closure $resolver)
    {
        $this->setResolver($resolver);
    }

    /**
     * @param Closure $closure
     */
    private function setResolver(Closure $closure): void
    {
        $this->resolver = $closure;
    }

    /**
     * @return ModelInterface
     */
    private function resolveModel(): ModelInterface
    {
        $resolver = $this->resolver;
        return $resolver();
    }
}
