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

namespace App\Kit\Model\Exception;

use RuntimeException;

final class ModelNotResolved extends RuntimeException
{
    /**
     * @param callable $resolver
     * @param mixed $resolved
     * @return ModelNotResolved
     */
    public static function create(callable $resolver, $resolved): self
    {
        $msg = 'Resolver "%s" did not return a Model; result was "%s"';
        $actual = (is_object($resolved)) ? get_class($resolved) : gettype($resolved);

        return new self(
            sprintf(
                $msg,
                get_class($resolver),
                $actual
            )
        );
    }
}
