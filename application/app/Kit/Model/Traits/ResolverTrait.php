<?php

declare(strict_types=1);

namespace App\Kit\Model\Traits;

use App\Kit\Model\Exception\IncorrectModelResolved;
use App\Kit\Model\ModelInterface;
use Closure;

trait ResolverTrait
{
    /**
     * @var ModelInterface
     */
    private ?ModelInterface $model;

    /**
     * @var callable
     */
    private Closure $resolver;

    /**
     * @param string $expected
     * @return ModelInterface
     */
    private function getModel(string $expected): ModelInterface
    {
        if (!isset($this->model)) {
            $this->model = $this->resolveModel($expected);
        }

        return $this->model;
    }

    /**
     * @param string $expected
     * @return ModelInterface
     */
    private function resolveModel(string $expected): ModelInterface
    {
        $resolver = $this->resolver;
        $model = $resolver();
        if (! $model instanceof $expected) {
            throw IncorrectModelResolved::fromModel($model, $expected);
        }

        return $model;
    }
}
