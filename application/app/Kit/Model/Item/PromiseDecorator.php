<?php

declare(strict_types=1);

namespace App\Kit\Model\Item;

final class PromiseDecorator implements ItemInterface
{
    private ?ItemInterface $item;

    private $resolver;

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
        if (!isset($this->item)) {
            $resolver = $this->resolver;
            $this->item = $resolver();
        }

        return $this->item;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return $this->resolve()->jsonSerialize();
    }
}
