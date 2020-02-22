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
use App\Kernel\BundleLoader\Exception\BundlesNotIterable;
use App\Kernel\BundleLoader\FileBundleLoader;
use Generator;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use Tests\Constants;

final class FileBundleLoaderTest extends TestCase
{
    public function testItLoadsBundles(): void
    {
        $bundlesPath = Constants::fixturesDir() . '/bundles/GoodBundles.php';
        $bundleFile = new SplFileInfo($bundlesPath);
        $targetEnv = 'foo';

        $fileBundleLoader = new FileBundleLoader($bundleFile, $targetEnv);

        $bundles = require $bundleFile;

        /** @var Generator $loadedBundles */
        $loadedBundles = $fileBundleLoader->getBundles();

        foreach ($bundles as $bundleClass => $envs) {
            if (isset($envs[$targetEnv])) {
                $this->assertTrue($loadedBundles->valid());
                $this->assertInstanceOf($bundleClass, $loadedBundles->current());
                $loadedBundles->next();
            }
        }
    }

    public function testItLoadsBundlesByEnvironment(): void
    {
        $bundlesPath = Constants::fixturesDir() . '/bundles/GoodMixedBundles.php';
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

    public function testItThrowsAnExceptionIfTheBundleFileContainsInvalidBundles(): void
    {
        $invalidBundles = Constants::fixturesDir() . '/bundles/InvalidBundles.php';

        $fileBundleLoader = FileBundleLoader::create($invalidBundles, 'foo');

        $this->expectExceptionObject(BundlesNotIterable::create($invalidBundles));

        $fileBundleLoader->getBundles();
    }
}
