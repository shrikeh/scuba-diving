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

namespace App\Kit\Model\Item;

use App\Kit\Model\Exception\IncorrectModelResolved;
use App\Kit\Model\ResolverDecorator\Traits\ClosureResolverTrait;

final class ResolverDecorator implements ItemInterface
{
    use ClosureResolverTrait;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->resolve()->getName();
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return $this->resolve()->jsonSerialize();
    }

    /**
     * @return ItemInterface
     * @throws IncorrectModelResolved If the resolved model doesn't match the expected type
     */
    private function resolve(): ItemInterface
    {
        if (!isset($this->model)) {
            $this->model = $this->resolveModel();
        }

        if (!$this->model instanceof ItemInterface) {
            throw IncorrectModelResolved::fromModel($this->model, ItemInterface::class);
        }

        return $this->model;
    }
}
