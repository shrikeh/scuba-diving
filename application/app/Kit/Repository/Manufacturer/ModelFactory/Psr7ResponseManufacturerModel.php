<?php

declare(strict_types=1);

namespace App\Kit\Repository\Manufacturer\ModelFactory;

use App\Api\ResponseParserInterface;
use App\Api\ResponseResolver\ResponseResolver;
use App\Kit\Model\Manufacturer\ManufacturerInterface;
use App\Kit\Model\Manufacturer\ResolverDecorator;
use Closure;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class Psr7ResponseManufacturerModel implements ManufacturerModelFactoryInterface
{
    /**
     * @var ResponseParserInterface
     */
    private ResponseParserInterface $responseParser;

    /**
     * Psr7ResponseManufacturerModel constructor.
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
        return new ResolverDecorator($this->createResolverClosure($response));
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