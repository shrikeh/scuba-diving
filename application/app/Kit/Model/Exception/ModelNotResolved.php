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
use Safe\Exceptions\StringsException;

use function Safe\sprintf;

final class ModelNotResolved extends RuntimeException
{
    /**
     * @param callable $resolver
     * @param mixed $resolved
     * @return ModelNotResolved
     * @throws StringsException
     */
    public static function create(callable $resolver, $resolved): self
    {
        $msg = 'Resolver "%s" did not return a Model; result was "%s"';

        return new self(
            sprintf(
                $msg,
                self::getInfo($resolver),
                self::getInfo($resolved)
            )
        );
    }

    /**
     * @param mixed $arg
     * @return string
     */
    private static function getInfo($arg): string
    {
        return (is_object($arg)) ? get_class($arg) : serialize($arg);
    }
}
