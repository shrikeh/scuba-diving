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

namespace Tests\Unit\App\Kernel\Traits;

use App\Kernel\Traits\BaseDirRelativeDirectoriesTrait;
use PHPUnit\Framework\TestCase;

final class BaseDirRelativeDirectoriesTraitTest extends TestCase
{
    public function testItReturnsTheCacheDir(): void
    {
        $trait = new class () {
            use BaseDirRelativeDirectoriesTrait {
                getDefaultCacheDir as public;
            }

            public function getProjectDir(): string
            {
                return 'foo/bar';
            }
        };

        $this->assertSame('foo/var/cache', $trait->getDefaultCacheDir());
    }

    public function testItReturnsTheLogDir(): void
    {
        $trait = new class () {
            use BaseDirRelativeDirectoriesTrait {
                getDefaultLogDir as public;
            }

            public function getProjectDir(): string
            {
                return 'foo/bar';
            }
        };

        $this->assertSame('foo/var/logs', $trait->getDefaultLogDir());
    }
}
