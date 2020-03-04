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

use App\Kit\Model\Exception\ModelNotResolved;
use App\Kit\Model\ModelInterface;
use Closure;
use Safe\Exceptions\StringsException;

trait ClosureResolverTrait
{
    /**
     * @var ModelInterface
     * @psalm-suppress PropertyNotSetInConstructor We need $model to be lazily set, as we get it from a promise.
     */
    private ModelInterface $model;

    /**
     * @var Closure
     */
    private Closure $resolver;

    /**
     * @var bool
     */
    private bool $resolved = false;

    /**
     * ClosureResolverTrait constructor.
     * @param Closure $resolver
     */
    private function __construct(Closure $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @return Closure
     */
    private function getResolver(): Closure
    {
        return $this->resolver;
    }

    /**
     * @return ModelInterface
     * @throws StringsException
     */
    private function fetchModel(): ModelInterface
    {
        if (!$this->resolved) {
            /** @var ModelInterface $model */
            $this->model = $this->resolveModel();
            $this->resolved = true;
        }

        return $this->model;
    }

    /**
     * @return ModelInterface
     * @throws StringsException
     */
    private function resolveModel(): ModelInterface
    {
        $resolver = $this->getResolver();
        $resolvedModel = $resolver();
        $this->assertModel($resolvedModel);

        return $resolvedModel;
    }

    /**
     * @param mixed $model
     * @assert ModelInterface $model
     * @throws ModelNotResolved If the resolver does not return a ModelInterface
     * @throws StringsException
     */
    private function assertModel($model): void
    {
        if (!$model instanceof ModelInterface) {
            throw ModelNotResolved::create($this->getResolver(), $model);
        }
    }
}
