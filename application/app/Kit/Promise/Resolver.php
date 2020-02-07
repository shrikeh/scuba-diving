<?php

declare(strict_types=1);

namespace App\Kit\Promise;

use App\Kit\Model\ModelInterface;
use App\Kit\ResponseParser\ResponseParserInterface;

final class Resolver
{
    private ResponseParserInterface $responseParser;
    /**
     * @var Wrapper
     */
    private Wrapper $wrapper;

    /**
     * Resolver constructor.
     * @param Wrapper $wrapper
     * @param ResponseParserInterface $responseParser
     */
    public function __construct(Wrapper $wrapper, ResponseParserInterface $responseParser)
    {
        $this->responseParser = $responseParser;
        $this->wrapper = $wrapper;
    }

    /**
     * @return mixed
     * @throws \Throwable
     */
    public function __invoke(): ModelInterface
    {
        $wrapper = $this->wrapper;
        $response = $wrapper();

        return $this->responseParser->parse($response);
    }
}
