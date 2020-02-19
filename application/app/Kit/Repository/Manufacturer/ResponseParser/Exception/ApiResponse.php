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
    /**
     * @param ExceptionInterface $exception
     *
     * @return ApiResponse
     */
    public static function wrap(ExceptionInterface $exception): self
    {
        return new self(
            $exception->getMessage(),
            (int) $exception->getCode(),
            $exception
        );
    }
}
