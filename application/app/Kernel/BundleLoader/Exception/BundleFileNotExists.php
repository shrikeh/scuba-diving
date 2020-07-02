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
use Safe\Exceptions\StringsException;

use function Safe\sprintf;

final class BundleFileNotExists extends RuntimeException
{
    /**
     * @param string $path
     * @return static
     * @throws StringsException
     * @SuppressWarnings(PHPMD.StaticAccess) Named constructor pattern
     */
    public static function fromPath(string $path): self
    {
        return new self(sprintf(
            'The path "%s" is not a file',
            $path
        ));
    }
}
