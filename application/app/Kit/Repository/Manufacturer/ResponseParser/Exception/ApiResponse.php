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

namespace App\Kit\Repository\Manufacturer\ResponseParser\Exception;

use RuntimeException;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

final class ApiResponse extends RuntimeException
{
    public const DEFAULT_CODE = 0;

    /**
     * @param ExceptionInterface $exception
     * @return ApiResponse
     * @SuppressWarnings(PHPMD.StaticAccess) Named constructor pattern
     */
    public static function wrap(ExceptionInterface $exception): self
    {
        /** @psalm-suppress PossiblyInvalidArgument */
        return new self(
            $exception->getMessage(),
            self::getExceptionCode($exception),
            $exception
        );
    }

    /**
     * @param ExceptionInterface $exception
     * @return int
     */
    private static function getExceptionCode(ExceptionInterface $exception): int
    {
        $code = $exception->getCode();

        return is_int($code) ? $code : self::DEFAULT_CODE;
    }
}
