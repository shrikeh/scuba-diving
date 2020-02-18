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

namespace App\Kit\Resolver;

use App\Kit\Model\ModelInterface;
use App\Api\ResponseParserInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class Response implements ResolverInterface
{
    /**
     * @var ResponseInterface
     */
    private ResponseInterface $response;

    /**
     * @var ResponseParserInterface
     */
    private ResponseParserInterface $responseParser;

    /**
     * Response constructor.
     * @param ResponseInterface $response
     * @param ResponseParserInterface $responseParser
     */
    public function __construct(ResponseInterface $response, ResponseParserInterface $responseParser)
    {
        $this->response = $response;
        $this->responseParser = $responseParser;
    }

    /**
     * @return ModelInterface
     */
    public function __invoke(): ModelInterface
    {
        return $this->responseParser->parse($this->response);
    }
}
