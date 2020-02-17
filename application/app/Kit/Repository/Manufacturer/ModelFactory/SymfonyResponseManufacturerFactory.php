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

use App\Api\ResponseParserInterface;
use App\Api\ResponseResolver\ResponseResolver;
use App\Kit\Model\Manufacturer\ManufacturerInterface;
use App\Kit\Model\Manufacturer\ResolverDecorator;
use Closure;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class SymfonyResponseManufacturerFactory implements ManufacturerModelFactoryInterface
{
    /**
     * @var ResponseParserInterface
     */
    private ResponseParserInterface $responseParser;

    /**
     * SymfonyResponseManufacturerFactory constructor.
     * @param ResponseParserInterface $responseParser
     */
    public function __construct(ResponseParserInterface $responseParser)
    {
        $this->responseParser = $responseParser;
    }

    /**
     * @param ResponseInterface $response
     * @return ManufacturerInterface
     */
    public function createManufacturerFromResponse(ResponseInterface $response): ManufacturerInterface
    {
        return ResolverDecorator::create($this->createResolverClosure($response));
    }

    /**
     * @param ResponseInterface $response
     * @return Closure
     */
    private function createResolverClosure(ResponseInterface $response): Closure
    {
        return Closure::fromCallable(new ResponseResolver($response, $this->responseParser));
    }
}
