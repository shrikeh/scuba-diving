<?php

declare(strict_types=1);

namespace App\Kit\ResponseParser;

use App\Kit\Model\ModelInterface;
use Psr\Http\Message\ResponseInterface;

final class ItemDetail implements ResponseParserInterface
{
    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    public function parse(ResponseInterface $response): ModelInterface
    {
        // TODO: Implement parse() method.
    }
}
