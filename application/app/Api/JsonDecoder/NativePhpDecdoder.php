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
