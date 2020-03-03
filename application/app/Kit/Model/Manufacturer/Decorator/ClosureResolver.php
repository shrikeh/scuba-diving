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

namespace App\Kit\Model\Manufacturer\Decorator;

use App\Kit\Model\Exception\IncorrectModelResolved;
use App\Kit\Model\Manufacturer\ManufacturerInterface;
use App\Kit\Model\ModelInterface;
use App\Kit\Model\ResolverDecorator\Traits\ClosureResolverTrait;
use Closure;

final class ClosureResolver implements ManufacturerInterface
{
    use ClosureResolverTrait;

    /**
     * @param callable $callable
     * @return self
     */
    public static function create(callable $callable): self
    {
        if (!$callable instanceof Closure) {
            $callable = Closure::fromCallable($callable);
        }

        return new self($callable);
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
     * @throws IncorrectModelResolved If the resolved model doesn't match the expected type
     */
    private function resolve(): ManufacturerInterface
    {
        /** @var ManufacturerInterface $model */
        $model = $this->fetchModel();
        $this->assertManufacturerModel($model);

        return $model;
    }

    /**
     * @param ModelInterface $model
     * @psalm-assert ManufacturerInterface
     */
    private function assertManufacturerModel(ModelInterface $model): void
    {
        if (!$model instanceof ManufacturerInterface) {
            throw IncorrectModelResolved::fromModel($model, ManufacturerInterface::class);
        }
    }
}
