<?php

declare(strict_types=1);

namespace App\Kit\Model\Manufacturer;

use App\Kit\Model\Exception\IncorrectModelResolved;
use App\Kit\Model\ResolverDecorator\Traits\ClosureResolverTrait;

final class ResolverDecorator implements ManufacturerInterface
{
    use ClosureResolverTrait;

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
     * @throws IncorrectModelResolved If the resolved model doesn't match the expected type
     */
    private function resolve(): ManufacturerInterface
    {
        if (!isset($this->model)) {
            $this->model = $this->resolveModel();
        }

        if (!$this->model instanceof ManufacturerInterface) {
            throw IncorrectModelResolved::fromModel($this->model, ManufacturerInterface::class);
        }

        return $this->model;
    }
}
