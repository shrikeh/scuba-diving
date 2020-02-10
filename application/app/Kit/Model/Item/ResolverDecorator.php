<?php

declare(strict_types=1);

namespace App\Kit\Model\Item;

use App\Kit\Model\Traits\ResolverTrait;
use Closure;

final class ResolverDecorator implements ItemInterface
{
    use ResolverTrait;

    /**
     * ResolverDecorator constructor.
     * @param Closure $resolver
     */
    public function __construct(Closure $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->resolveItem()->getName();
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return $this->resolveItem()->jsonSerialize();
    }

    /**
     * @return ItemInterface
     */
    private function resolveItem(): ItemInterface
    {
        return $this->getModel(ItemInterface::class);
    }
}
