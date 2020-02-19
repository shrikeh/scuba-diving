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

namespace App\Kit\Resolver\Exception;

use RuntimeException;

final class ModelNotResolved extends RuntimeException
{
    /**
     * @param mixed  $resolved
     * @param string $expected
     *
     * @return ModelNotResolved
     */
    public static function fromResolved($resolved, string $expected): self
    {
        $msg = 'Expected to resolve an instance of "%s", got "%s" instead';

        $actual = (is_object($resolved)) ? get_class($resolved) : gettype($resolved);

        return new self(sprintf($msg, $expected, $actual));
    }
}
