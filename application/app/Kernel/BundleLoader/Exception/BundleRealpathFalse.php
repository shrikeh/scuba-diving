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

use Safe\Exceptions\StringsException;
use SplFileInfo;
use RuntimeException;

use function Safe\sprintf;

final class BundleRealpathFalse extends RuntimeException
{
    /**
     * @param SplFileInfo $bundlePath
     * @return static
     * @throws StringsException
     * @SuppressWarnings(PHPMD.StaticAccess) Named constructor pattern
     */
    public static function create(SplFileInfo $bundlePath): self
    {
        return new self(sprintf(
            'The realpath of the path "%s" returned false',
            $bundlePath->getPathname()
        ));
    }
}
