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

use RuntimeException;

use function Safe\sprintf;

final class BundlesNotIterable extends RuntimeException
{
    /**
     * @param string $path
     * @return static
     * @throws \Safe\Exceptions\StringsException
     */
    public static function create(string $path): self
    {
        return new self(sprintf(
            'File "%s" did not return iterable of bundles',
            $path
        ));
    }
}
