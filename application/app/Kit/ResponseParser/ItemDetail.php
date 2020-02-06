<?php

declare(strict_types=1);

namespace App\Kit\ResponseParser;

use Psr\Http\Message\ResponseInterface;

final class ItemDetail implements ResponseParserInterface
{

    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    public function parse(ResponseInterface $response)
    {
        // TODO: Implement parse() method.
    }
}
