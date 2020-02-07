<?php

declare(strict_types=1);

namespace App\Kit\Model\Item;

use App\Kit\Model\Traits\PromiseResolveTrait;

final class PromiseDecorator implements ItemInterface
{
    use PromiseResolveTrait;

    /**
     * PromiseDecorator constructor.
     * @param callable $resolver
     */
    public function __construct(callable $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->resolve()->getName();
    }

    /**
     * @return ItemInterface
     */
    private function resolve(): ItemInterface
    {
        return $this->resolveModel();
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return $this->resolve()->jsonSerialize();
    }
}
