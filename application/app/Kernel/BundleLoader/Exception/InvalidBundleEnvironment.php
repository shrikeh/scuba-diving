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

use InvalidArgumentException;

use function Safe\sprintf;

final class InvalidBundleEnvironment extends InvalidArgumentException
{
    /**
     * @param string $bundle
     * @param mixed $environment
     * @return static
     * @throws \Safe\Exceptions\StringsException
     */
    public static function fromBundleEnv(string $bundle, $environment): self
    {
        return new self(sprintf(
            'The bundle "%s" included the invalid environment %s',
            $bundle,
            serialize($environment)
        ));
    }
}
