<?php

declare(strict_types=1);

namespace App\Api\JsonDecoder;

final class NativePhpDecdoder implements JsonDecoderInterface
{
    /**
     * {@inheritDoc}
     */
    public function decode(string $json): object
    {
        return json_decode($json);
    }
}
