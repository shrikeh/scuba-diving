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

use App\Kernel\BundleLoader\BundleIterator\Exception\BundleEnvironmentsNotIterable;
use App\Kernel\BundleLoader\BundleIterator\Exception\BundlesNotIterable;
use App\Kernel\BundleLoader\BundleIterator\Exception\InvalidBundleEnvironment;
use App\Kernel\BundleLoader\Exception\BundleFileNotExists;
use App\Kernel\BundleLoader\Exception\BundleFileNotReadable;
use App\Kernel\BundleLoader\Exception\BundleRealpathFalse;
use App\Kernel\BundleLoader\Exception\BundlesNotLoadable;
use App\Kernel\BundleLoader\FileBundleLoader;
use Generator;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use Tests\Constants;

final class FileBundleLoaderTest extends TestCase
{
    public function testItLoadsBundles(): void
    {
        $bundlesPath = Constants::fixturesDir() . '/config/bundles.php';
        $bundles = require $bundlesPath;

        $bundleFile = $this->prophesize(SplFileInfo::class);
        $bundleFile->isFile()->willReturn(true);
        $bundleFile->isReadable()->willReturn(true);
        $bundleFile->getRealPath()->willReturn($bundlesPath);
        $bundleFile->getRealPath()->shouldBeCalledOnce();

        $targetEnv = 'foo';

        $fileBundleLoader = new FileBundleLoader($bundleFile->reveal(), $targetEnv);

        /** @var Generator $loadedBundles */
        $loadedBundles = $fileBundleLoader->getBundles();

        foreach ($bundles as $bundleClass => $envs) {
            if (isset($envs[$targetEnv])) {
                $this->assertTrue($loadedBundles->valid());
                $this->assertInstanceOf($bundleClass, $loadedBundles->current());
                $loadedBundles->next();
            }
        }
        // force a second call to ensure that the file is not reloaded
        $fileBundleLoader->getBundles();
    }

    public function testItLoadsBundlesByEnvironment(): void
    {
        $bundlesPath = Constants::fixturesDir() . '/config/GoodMixedBundles.php';
        $bundleFile = new SplFileInfo($bundlesPath);
        $targetEnv = 'bar';

        $fileBundleLoader = new FileBundleLoader($bundleFile, $targetEnv);

        $bundles = require $bundleFile;
        $bundlesRegistered = [];
        foreach ($bundles as $bundleClass => $envs) {
            if ($envs[$targetEnv] ?? $envs['all'] ?? false) {
                $bundlesRegistered[] = $bundleClass;
            }
        }

        $this->assertCount(count($bundlesRegistered), iterator_to_array($fileBundleLoader->getBundles()));

        /** @var Generator $loadedBundles */
        $loadedBundles = $fileBundleLoader->getBundles();

        foreach ($bundlesRegistered as $bundleClass) {
            $this->assertTrue($loadedBundles->valid());
            $this->assertInstanceOf($bundleClass, $loadedBundles->current());
            $loadedBundles->next();
        }
    }

    public function testItThrowsABundleRealpathFalseException(): void
    {
        $fileBundle = $this->prophesize(SplFileInfo::class);
        $path = 'foo';

        $fileBundle->isFile()->willReturn(true);
        $fileBundle->isReadable()->willReturn(true);
        $fileBundle->getPathname()->willReturn($path);
        $fileBundle->getRealPath()->willReturn(false);

        $splFileBundle = $fileBundle->reveal();

        $this->expectExceptionObject(BundleRealpathFalse::create($splFileBundle));

        $fileBundleLoader = new FileBundleLoader($splFileBundle, 'dev');

        $fileBundleLoader->getBundles();
    }

    public function testItThrowsABundleFileNotExistsExceptionIfTheFileDoesNotExist(): void
    {
        $fileBundle = $this->prophesize(SplFileInfo::class);
        $path = 'foo';

        $fileBundle->isFile()->willReturn(false);
        $fileBundle->getPathname()->willReturn($path);
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
        $fileBundle->getPathname()->willReturn($path);
        $this->expectExceptionObject(BundleFileNotReadable::fromPath($path));

        $fileBundleLoader = new FileBundleLoader($fileBundle->reveal(), 'dev');

        $fileBundleLoader->getBundles();
    }

    public function testItThrowsAnExceptionIfTheBundleFileContainsInvalidBundles(): void
    {
        $invalidBundles = Constants::fixturesDir() . '/config/InvalidBundles.php';

        $fileBundleLoader = FileBundleLoader::create($invalidBundles, 'foo');

        $this->expectException(BundlesNotLoadable::class);
        $this->expectExceptionCode(0);

        $fileBundleLoader->getBundles();
    }
}
