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

namespace App\Kit\Query\Bus\Exception;

use Symfony\Component\Messenger\Exception\RuntimeException;

final class IncorrectResultType extends RuntimeException
{
    /**
     * @param mixed  $result
     * @param string $expected
     *
     * @return IncorrectResultType
     */
    public static function fromMessage($result, string $expected): self
    {
        $actual = is_object($result) ? get_class($result) : gettype($result);

        return new self(sprintf(
            'Expected query to return "%s", instance of "%s" returned instead',
            $actual,
            $expected
        ));
    }
}
