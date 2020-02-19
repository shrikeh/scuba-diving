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

namespace App\Kit\Repository\ResolverFactory;

use App\Api\ResponseParserInterface;
use App\Kit\Resolver\ResolverInterface;
use App\Kit\Resolver\Response;
use Ramsey\Uuid\UuidInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class SymfonyResponse implements ResolverFactoryInterface
{
    /**
     * @var ResponseParserInterface
     */
    private ResponseParserInterface $responseParser;

    /**
     * SymfonyResponseManufacturerFactory constructor.
     *
     * @param ResponseParserInterface $responseParser
     */
    public function __construct(ResponseParserInterface $responseParser)
    {
        $this->responseParser = $responseParser;
    }

    /**
     * @param ResponseInterface $response
     * @param UuidInterface     $uuid
     *
     * @return ResolverInterface
     */
    public function createResolver(ResponseInterface $response, UuidInterface $uuid): ResolverInterface
    {
        return new Response($response, $this->responseParser);
    }
}
