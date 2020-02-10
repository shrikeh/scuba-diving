<?php

declare(strict_types=1);

namespace App\Kit\Repository\Manufacturer\ModelFactory;

use App\Kit\Model\Manufacturer\ManufacturerInterface;
use Psr\Http\Message\ResponseInterface;

interface ManufacturerModelFactoryInterface
{
    /**
     * @param ResponseInterface $response
     * @return ManufacturerInterface
     */
    public function createManufacturerFromResponse(ResponseInterface $response): ManufacturerInterface;
}
