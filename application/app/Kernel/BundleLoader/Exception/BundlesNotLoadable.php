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

namespace App\Kernel\BundleLoader\Exception;

use App\Kernel\BundleLoader\BundleIterator\Exception\BundleIteratorExceptionInterface;
use RuntimeException;
use Safe\Exceptions\StringsException;

use function Safe\sprintf;

final class BundlesNotLoadable extends RuntimeException
{
    /**
     * @param BundleIteratorExceptionInterface $e
     * @param string $path
     * @return static
     * @throws StringsException
     * @SuppressWarnings(PHPMD.StaticAccess) Named constructor pattern
     */
    public static function fromBundleIteratorException(BundleIteratorExceptionInterface $e, string $path): self
    {
        $msg = sprintf(
            'The file %s was not readable and produced the following exception: %s',
            $path,
            $e->getMessage()
        );

        return new self($msg, 0, $e);
    }
}
