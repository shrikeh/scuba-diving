<?php

declare(strict_types=1);

namespace App\Api\ResponseResolver;

use App\Kit\Model\ModelInterface;
use App\Api\ResponseParserInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

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
     * @return ModelInterface
     */
    public function __invoke(): ModelInterface
    {
        return $this->responseParser->parse($this->response);
    }
}
