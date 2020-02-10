<?php

declare(strict_types=1);

namespace App\Kit\ResponseResolver;

use App\Kit\Model\ModelInterface;
use App\Kit\ResponseParser\ResponseParserInterface;
use Psr\Http\Message\ResponseInterface;

final class ResponseResolver
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
     * ResponseResolver constructor.
     * @param ResponseInterface $response
     * @param ResponseParserInterface $responseParser
     */
    public function __construct(ResponseInterface $response, ResponseParserInterface $responseParser)
    {
        $this->response = $response;
        $this->responseParser = $responseParser;
    }

    /**
     * @return mixed
     */
    public function __invoke(): ModelInterface
    {
        return $this->responseParser->parse($this->response);
    }
}
