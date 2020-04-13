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

namespace App\Kernel;

interface EnvironmentConfigurableKernelInterface
{
    public const ENV_LOG_DIR_KEY = 'SYMFONY_LOG_DIR';
    public const ENV_CACHE_DIR_KEY = 'SYMFONY_CACHE_DIR';
    public const ENV_CONFIG_DIR_KEY = 'SYMFONY_CONFIG_DIR';
    public const ENV_BUNDLE_FILE_KEY = 'SYMFONY_BUNDLE_FILE';
}
