<?php

declare(strict_types=1);

namespace App\Kit\Repository\Item\ModelFactory;

use App\Kit\Model\Item\ItemInterface;
use App\Kit\Model\Item\ResolverDecorator;
use App\Kit\ResponseParser\ResponseParserInterface;
use App\Kit\ResponseResolver\ResponseResolver;
use Closure;
use Psr\Http\Message\ResponseInterface;

final class Psr7ResponseItemModel implements ItemModelFactoryInterface
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
     * @return ItemInterface
     */
    public function createItemFromResponse(ResponseInterface $response): ItemInterface
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
