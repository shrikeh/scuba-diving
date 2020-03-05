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

namespace App\Kit\Resolver\Cache\Exception;

use InvalidArgumentException;
use Ramsey\Uuid\UuidInterface;
use Safe\Exceptions\StringsException;
use Throwable;

use function Safe\sprintf;

final class InvalidCacheArgument extends InvalidArgumentException
{
    /**
     * @param UuidInterface $uuid
     * @param Throwable $previous
     * @return InvalidCacheArgument
     * @throws StringsException
     * @SuppressWarnings(PHPMD.StaticAccess) Named constructor pattern
     */
    public static function create(UuidInterface $uuid, Throwable $previous): self
    {
        return new self(
            sprintf(
                'Failed to load model "%s": %s',
                $uuid->toString(),
                $previous->getMessage()
            ),
            0,
            $previous
        );
    }
}
