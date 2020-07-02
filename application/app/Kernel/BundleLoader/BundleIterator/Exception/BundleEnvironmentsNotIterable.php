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

use InvalidArgumentException;
use Safe\Exceptions\StringsException;

use function Safe\sprintf;

final class BundleEnvironmentsNotIterable extends InvalidArgumentException implements BundleIteratorExceptionInterface
{
    /**
     * @param string $bundle
     * @return static
     * @throws StringsException
     * @SuppressWarnings(PHPMD.StaticAccess) Named constructor pattern
     */
    public static function fromBundle(string $bundle): self
    {
        return new self(sprintf(
            'The bundle "%s" did not include an iterable list of environments',
            $bundle
        ));
    }
}
