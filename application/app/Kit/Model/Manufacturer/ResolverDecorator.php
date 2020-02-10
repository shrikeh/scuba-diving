<?php

declare(strict_types=1);

namespace App\Kit\Model\Manufacturer;

use App\Kit\Model\Traits\ResolverTrait;

final class ResolverDecorator implements ManufacturerInterface
{
    use ResolverTrait;

    /**
     * ResolverDecorator constructor.
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
        return $this->resolveManufacturer()->jsonSerialize();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->resolveManufacturer()->getName();
    }

    /**
     * @return ManufacturerInterface
     */
    private function resolveManufacturer(): ManufacturerInterface
    {
        return $this->getModel(ManufacturerInterface::class);
    }
}
