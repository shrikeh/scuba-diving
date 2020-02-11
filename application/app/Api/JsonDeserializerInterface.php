<?php

declare(strict_types=1);

namespace App\Api;

interface JsonDeserializerInterface
{
    /**
     * @param string $json
     * @return object
     */
    public function deserialize(string $json): object;
}
