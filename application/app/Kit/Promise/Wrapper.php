<?php

declare(strict_types=1);

namespace App\Kit\Promise;

use Psr\Http\Message\ResponseInterface;

final class Wrapper
{
    private Collection $collection;

    private string $key;

    /**
     * Wrapper constructor.
     * @param $collection
     * @param $key
     */
    public function __construct(Collection $collection, string $key)
    {
        $this->collection = $collection;
        $this->key = $key;
    }

    /**
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function __invoke(): ResponseInterface
    {
        return $this->collection->unwrap($this->key);
    }
}
