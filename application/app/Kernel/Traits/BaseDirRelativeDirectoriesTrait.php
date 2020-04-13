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

use function dirname;

trait BaseDirRelativeDirectoriesTrait
{
    /**
     * @return string
     */
    abstract public function getProjectDir(): string;

    /**
     * @return string
     */
    private function getBaseDir(): string
    {
        return dirname($this->getProjectDir());
    }

    /**
     * @return string
     */
    private function getVarDir(): string
    {
        return $this->getBaseDir() . '/var';
    }

    /**
     * @return string
     */
    private function getDefaultCacheDir(): string
    {
        return $this->getVarDir() . '/cache';
    }

    /**
     * @return string
     */
    private function getDefaultLogDir(): string
    {
        return $this->getVarDir() . '/logs';
    }
}
