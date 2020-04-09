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

use App\Kernel\EnvironmentConfigurableKernelInterface as EnvironmentConfigurableKernel;
use Symfony\Component\HttpFoundation\ParameterBag;

trait EnvironmentConfigurationTrait
{
    /**
     * @var ParameterBag
     */
    private ParameterBag $serverBag;

    /**
     * {@inheritdoc}
     */
    public function getLogDir(): string
    {
        return $this->getEnvVar(EnvironmentConfigurableKernel::ENV_LOG_DIR_KEY) ?? $this->getDefaultLogDir();
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir(): string
    {
        return $this->getEnvVar(EnvironmentConfigurableKernel::ENV_CACHE_DIR_KEY) ?? $this->getDefaultCacheDir();
    }

    /**
     * @return string
     */
    public function getBundleFile(): string
    {
        return $this->getEnvVar(EnvironmentConfigurableKernel::ENV_BUNDLE_FILE_KEY)
            ?? $this->getDefaultBundleFile() ;
    }

    /**
     * @return string
     */
    public function getConfigDir(): string
    {
        return $this->getEnvVar(EnvironmentConfigurableKernel::ENV_CONFIG_DIR_KEY) ??
            $this->getDefaultConfigDir();
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

    /**
     * @return string
     */
    abstract protected function getDefaultConfigDir(): string;

    /**
     * @return string
     */
    abstract protected function getDefaultBundleFile(): string;

    /**
     * @param string $key
     * @return string|null
     */
    private function getEnvVar(string $key): ?string
    {
        return $this->serverBag->get($key);
    }
}
