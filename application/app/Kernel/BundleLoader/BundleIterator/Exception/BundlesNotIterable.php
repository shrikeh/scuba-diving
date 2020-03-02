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

namespace App\Kernel\BundleLoader\BundleIterator\Exception;

use RuntimeException;

use function Safe\sprintf;

final class BundlesNotIterable extends RuntimeException implements BundleIteratorExceptionInterface
{
    /**
     * @param mixed $bundles
     * @return static
     * @throws \Safe\Exceptions\StringsException
     * @throws \Safe\Exceptions\JsonException
     */
    public static function create($bundles): self
    {
        return new self(sprintf(
            'The bundles were not iterable: received this: "%s"',
            serialize($bundles)
        ));
    }
}
