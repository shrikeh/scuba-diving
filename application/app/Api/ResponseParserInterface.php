<?php

declare(strict_types=1);

namespace App\Api;

use App\Kit\Model\ModelInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ResponseParserInterface
{
    /**
     * @param ResponseInterface $response
     * @return ModelInterface
     */
    public function parse(ResponseInterface $response): ModelInterface;
}
