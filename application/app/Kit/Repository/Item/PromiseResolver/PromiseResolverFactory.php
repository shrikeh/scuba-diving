<?php

declare(strict_types=1);

namespace App\Kit\Repository\Item\PromiseResolver;

use App\Kit\Model\Item\ItemInterface;
use App\Kit\Model\Item\PromiseDecorator;
use App\Kit\Promise\Collection;
use App\Kit\Promise\Resolver;
use App\Kit\ResponseParser\ResponseParserInterface;
use GuzzleHttp\Promise\PromiseInterface;

final class PromiseResolverFactory implements PromiseResolverFactoryInterface
{
    /**
     * @var Collection
     */
    private Collection $collection;

    /**
     * @var ResponseParserInterface
     */
    private ResponseParserInterface $responseParser;

    /**
     * PromiseResolverFactory constructor.
     * @param $collection
     * @param $responseParser
     */
    public function __construct(Collection $collection, ResponseParserInterface $responseParser)
    {
        $this->collection = $collection;
        $this->responseParser = $responseParser;
    }

    /**
     * {@inheritDoc}
     */
    public function create(PromiseInterface $promise, string $key): ItemInterface
    {
        $wrapper = $this->collection->wrap($promise, $key);

        $resolver = new Resolver(
            $wrapper,
            $this->responseParser
        );

        return new PromiseDecorator($resolver);
    }
}
