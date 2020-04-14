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

use SplFileInfo;

trait BaseDirRelativeDirectoriesTrait
{
    /**
     * @var SplFileInfo
     */
    private SplFileInfo $projectDir;

    /**
     * @return string
     */
    abstract public function getProjectDir(): string;

    /**
     * @return string
     */
    private function getBaseDir(): string
    {
        return $this->getProjectDirSplFileInfo()->getPath();
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

    /**
     * @return SplFileInfo
     */
    private function getProjectDirSplFileInfo(): SplFileInfo
    {
        if (!isset($this->projectDir)) {
            $this->projectDir = new SplFileInfo($this->getProjectDir());
        }

        return $this->projectDir;
    }
}
