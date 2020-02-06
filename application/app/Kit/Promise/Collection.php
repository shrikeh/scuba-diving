<?php

declare(strict_types=1);

namespace App\Kit\Promise;

use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use Ds\Map;
use Psr\Http\Message\ResponseInterface;

final class Collection
{
    /**
     * @var Map
     */
    private Map $promises;

    /**
     * Collection constructor.
     */
    public function __construct()
    {
        $this->promises = new Map();
    }

    /**
     * @param PromiseInterface $promise
     * @param string $key
     * @return Wrapper
     */
    public function wrap(PromiseInterface $promise, string $key): Wrapper
    {
        $this->promises->put($key, $promise);

        return new Wrapper($this, $key);
    }

    /**
     * @param string $key
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function unwrap(string $key): ResponseInterface
    {
        $responses = $this->unwrapAll();

        return $responses->get($key);
    }

    /**
     * @return Map
     * @throws \Throwable
     */
    private function unwrapAll(): Map
    {
        $responses = Promise\unwrap($this->promises->toArray());

        return new Map($responses);
    }
}
