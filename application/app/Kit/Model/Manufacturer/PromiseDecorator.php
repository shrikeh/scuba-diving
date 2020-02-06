<?php

declare(strict_types=1);

namespace App\Kit\Model\Manufacturer;

final class PromiseDecorator implements ManufacturerInterface
{
    private ?ManufacturerInterface $manufacturer;

    /**
     * @var callable
     */
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
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return $this->resolve()->jsonSerialize();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->resolve()->getName();
    }

    /**
     * @return ManufacturerInterface
     */
    private function resolve(): ManufacturerInterface
    {
        if (!isset($this->manufacturer)) {
            $resolver = $this->resolver;
            $this->manufacturer = $resolver();
        }

        return $this->manufacturer;
    }
}
