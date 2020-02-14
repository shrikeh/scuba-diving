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

namespace App\Kit\Repository\Manufacturer\ModelFactory;

use App\Kit\Model\Manufacturer\ManufacturerInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ManufacturerModelFactoryInterface
{
    /**
     * @param ResponseInterface $response
     * @return ManufacturerInterface
     */
    public function createManufacturerFromResponse(ResponseInterface $response): ManufacturerInterface;
}
