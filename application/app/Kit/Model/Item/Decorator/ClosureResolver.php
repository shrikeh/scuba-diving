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

namespace App\Kit\Model\Item\Decorator;

use App\Kit\Model\Exception\IncorrectModelResolved;
use App\Kit\Model\Item\ItemInterface;
use App\Kit\Model\ResolverDecorator\Traits\ClosureResolverTrait;
use Closure;

final class ClosureResolver implements ItemInterface
{
    use ClosureResolverTrait;

    /**
     * @param callable $callable
     *
     * @return ClosureResolver
     */
    public static function create(callable $callable): self
    {
        if (!$callable instanceof Closure) {
            $callable = Closure::fromCallable($callable);
        }

        return new self($callable);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->resolve()->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->resolve()->jsonSerialize();
    }

    /**
     * @throws IncorrectModelResolved If the resolved model doesn't match the expected type
     *
     * @return ItemInterface
     */
    private function resolve(): ItemInterface
    {
        $model = $this->fetchModel();

        if (!$model instanceof ItemInterface) {
            throw IncorrectModelResolved::fromModel($model, ItemInterface::class);
        }

        return $model;
    }
}
