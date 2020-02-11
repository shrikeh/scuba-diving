<?php

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
     * ClosureResolverTrait constructor.
     * @param Closure $resolver
     */
    public function __construct(Closure $resolver)
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
