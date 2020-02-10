<?php

declare(strict_types=1);

namespace App\Kit\Repository\RequestFactory;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

final class GuzzleRequestFactory implements RequestFactoryInterface
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $baseRequest;

    /**
     * GuzzleRequestFactory constructor.
     * @param $baseRequest
     */
    public function __construct(RequestInterface $baseRequest)
    {
        $this->baseRequest = $baseRequest;
    }

    /**
     * Create a new request.
     *
     * @param string $method The HTTP method associated with the request.
     * @param UriInterface|string $uri The URI associated with the request. If
     *     the value is a string, the factory MUST create a UriInterface
     *     instance based on it.
     *
     * @return RequestInterface
     */
    public function createRequest(string $method, $uri): RequestInterface
    {
        return $this->baseRequest->withMethod($method)->withUri(
            $this->addBaseUri($uri),
            true
        );
    }

    /**
     * @param $uri
     * @return UriInterface
     */
    private function addBaseUri($uri): UriInterface
    {
        if (!$uri instanceof UriInterface) {
            $uri = new Uri($uri);
        }

        return UriResolver::resolve($this->baseRequest->getUri(), $uri);
    }
}
