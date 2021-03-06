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
use Safe\Exceptions\StringsException;

final class ClosureResolver implements ManufacturerInterface
{
    use ClosureResolverTrait;

    /**
     * @param callable $callable
     * @return self
     * @SuppressWarnings(PHPMD.StaticAccess) Named constructor pattern
     */
    public static function create(callable $callable): self
    {
        if (!$callable instanceof Closure) {
            $callable = Closure::fromCallable($callable);
        }

        return new static($callable);
    }

    /**
     * {@inheritDoc}
     * @throws StringsException
     */
    public function jsonSerialize()
    {
        return $this->resolve()->jsonSerialize();
    }

    /**
     * @return string
     * @throws StringsException
     */
    public function getName(): string
    {
        return $this->resolve()->getName();
    }

    /**
     * @return ManufacturerInterface
     * @psalm-suppress RedundantConditionGivenDocblockType We need this for phpstan
     * @throws IncorrectModelResolved If the resolved model doesn't match the expected type
     * @throws StringsException
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
     * @assert ManufacturerInterface $model
     */
    private function assertManufacturerModel(ModelInterface $model): void
    {
        if (!$model instanceof ManufacturerInterface) {
            throw IncorrectModelResolved::fromModel($model, ManufacturerInterface::class);
        }
    }
}
