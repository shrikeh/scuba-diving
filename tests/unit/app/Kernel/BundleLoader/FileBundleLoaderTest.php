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

use App\Kernel\BundleLoader\FileBundleLoader;
use App\Kernel\DefaultKernel;
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

        $registeredBundles = $kernel->registerBundles();
        $loadedBundles = $fileBundleLoader->getBundles();

        while ($registeredBundles->valid()) {
            $this->assertSame(get_class($registeredBundles->current()), get_class($loadedBundles->current()));
            $registeredBundles->next();
            $loadedBundles->next();
        }
    }
}
