<?php

declare(strict_types=1);

namespace App\Kit\Repository\Item\PromiseResolver;

use App\Kit\Model\Item\ItemInterface;
use GuzzleHttp\Promise\PromiseInterface;

interface PromiseResolverFactoryInterface
{
    /**
     * @param PromiseInterface $promise
     * @param string $key
     * @return ItemInterface
     */
    public function create(PromiseInterface $promise, string $key): ItemInterface;
}
