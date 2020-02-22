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

namespace Tests\Unit\App\Kernel\BundleLoader;

use App\Kernel\BundleLoader\Exception\BundleFileNotExists;
use App\Kernel\BundleLoader\Exception\BundleFileNotReadable;
use App\Kernel\BundleLoader\FileBundleLoader;
use App\Kernel\DefaultKernel;
use Generator;
use SplFileInfo;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class FileBundleLoaderTest extends KernelTestCase
{
    public function testItLoadsBundles(): void
    {
        /** @var DefaultKernel $kernel */
        $kernel = self::createKernel();

        $bundleFile = new SplFileInfo($kernel->getBundleFile());

        $fileBundleLoader = new FileBundleLoader($bundleFile, $kernel->getEnvironment());

        /** @var Generator $registeredBundles */
        $registeredBundles = $kernel->registerBundles();

        /** @var Generator $loadedBundles */
        $loadedBundles = $fileBundleLoader->getBundles();

        while ($registeredBundles->valid()) {
            $this->assertSame(get_class($registeredBundles->current()), get_class($loadedBundles->current()));
            $registeredBundles->next();
            $loadedBundles->next();
        }
    }

    public function testItThrowsABundleFileNotExistsExceptionIfTheFileDoesNotExist(): void
    {
        $fileBundle = $this->prophesize(SplFileInfo::class);
        $path = 'foo';

        $fileBundle->isFile()->willReturn(false);
        $fileBundle->getPath()->willReturn($path);
        $this->expectExceptionObject(BundleFileNotExists::fromPath($path));

        $fileBundleLoader = new FileBundleLoader($fileBundle->reveal(), 'dev');

        $fileBundleLoader->getBundles();
    }

    public function testItThrowsABundleFileNotReadableExceptionIfTheBundleFileIsNotReadable(): void
    {
        $fileBundle = $this->prophesize(SplFileInfo::class);
        $path = 'foo';

        $fileBundle->isFile()->willReturn(true);
        $fileBundle->isReadable()->willReturn(false);
        $fileBundle->getPath()->willReturn($path);
        $this->expectExceptionObject(BundleFileNotReadable::fromPath($path));

        $fileBundleLoader = new FileBundleLoader($fileBundle->reveal(), 'dev');

        $fileBundleLoader->getBundles();
    }
}
