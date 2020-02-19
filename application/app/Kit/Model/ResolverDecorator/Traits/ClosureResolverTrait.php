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

trait ClosureResolverTrait
{
    /**
     * @var ModelInterface
     */
    private ?ModelInterface $model = null;

    /**
     * @var Closure
     */
    private Closure $resolver;

    /**
     * ClosureResolverTrait constructor.
     *
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
     */
    private function fetchModel(): ModelInterface
    {
        if (!isset($this->model)) {
            $this->model = $this->resolveModel();
        }

        return $this->model;
    }

    /**
     * @return ModelInterface
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
     * @psalm-assert ModelInterface $model
     *
     * @throws ModelNotResolved If the resolver does not return a ModelInterface
     */
    private function assertModel($model): void
    {
        if (!$model instanceof ModelInterface) {
            throw ModelNotResolved::create($this->getResolver(), $model);
        }
    }
}
