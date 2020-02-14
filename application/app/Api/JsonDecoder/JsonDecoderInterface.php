<?php

declare(strict_types=1);

namespace App\Api\JsonDecoder;

interface JsonDecoderInterface
{
    /**
     * @param string $json
     * @return object
     */
    public function decode(string $json): object;
}
