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

namespace App\Kernel\Traits;

use App\Kernel\EnvironmentConfigurableKernelInterface;
use App\Kernel\EnvironmentConfigurableKernelInterface as EnvironmentConfigurableKernel;

trait EnvironmentConfigurationTrait
{
    /**
     * {@inheritdoc}
     */
    public function getLogDir(): string
    {
        return ($_ENV[EnvironmentConfigurableKernel::ENV_LOG_DIR_KEY] ?? parent::getLogDir());
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir(): string
    {
        return ($_ENV[EnvironmentConfigurableKernel::ENV_CACHE_DIR_KEY] ?? $this->getDefaultCacheDir());
    }

    /**
     * @return string
     */
    public function getBundleFile(): string
    {
        return $_ENV[EnvironmentConfigurableKernel::ENV_BUNDLE_FILE_KEY] ?? $this->getConfigDir() . '/bundles.php';
    }

    /**
     * @return string
     */
    public function getConfigDir(): string
    {
        return $_ENV[EnvironmentConfigurableKernel::ENV_CONFIG_DIR_KEY] ?? $this->getProjectDir() . '/config';
    }

    /**
     * @return string
     */
    abstract public function getProjectDir(): string;

    /**
     * @return string
     */
    abstract protected function getDefaultCacheDir(): string;

    /**
     * @return string
     */
    abstract protected function getDefaultLogDir(): string;
}
