<?php

declare(strict_types=1);

namespace App\Kit\Repository\Manufacturer\PromiseResolver;

use App\Kit\Model\Manufacturer\ManufacturerInterface;
use GuzzleHttp\Promise\PromiseInterface;

interface PromiseResolverFactoryInterface
{
    /**
     * @param PromiseInterface $promise
     * @param string $key
     * @return ManufacturerInterface
     */
    public function create(PromiseInterface $promise, string $key): ManufacturerInterface;
}
