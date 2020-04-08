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

namespace Tests\Unit\App\Kernel;

use App\Kernel\DefaultKernel;
use App\Kernel\ScubaDivingKernelInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tests\Constants;

final class DefaultKernelTest extends KernelTestCase
{
    /**
     * @var array
     */
    private array $originalEnv;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->originalEnv = $_ENV;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $_ENV = $this->originalEnv;
    }

    public function testItReturnsTheProjectDir(): void
    {
        $kernel = self::createKernel();

        $this->assertSame(Constants::appDir(), $kernel->getProjectDir());
    }

    public function testItUsesTheLogDirEnvVar(): void
    {
        $logDir = '/foo';
        $_ENV[DefaultKernel::ENV_LOG_DIR_KEY] = $logDir;
        $kernel = new DefaultKernel('test', false);

        $this->assertSame($logDir, $kernel->getLogDir());
    }

    public function testItUsesTheCacheDirEnvVar(): void
    {
        $caheDir = '/bar';
        $_ENV[DefaultKernel::ENV_CACHE_DIR_KEY] = $caheDir;
        $kernel = new DefaultKernel('test', false);

        $this->assertSame($caheDir, $kernel->getCacheDir());
    }

    /**
     * @covers \App\Kernel\DefaultKernel::configureContainer()
     */
    public function testItConfiguresAContainer(): void
    {
        $kernel = self::bootKernel();

        $this->assertInstanceOf(ContainerInterface::class, $kernel->getContainer());
    }

    public function testItUsesTheConfigDirEnvVar(): void
    {
        $bundlePath = Constants::fixturesDir() . '/config/GoodMixedBundles.php';
        $_ENV[DefaultKernel::ENV_BUNDLE_FILE_KEY] = $bundlePath;

        $kernel = self::bootKernel();
        $bundles = require $bundlePath;

        $bundlesRegistered = [];

        foreach ($bundles as $bundleClass => $envs) {
            if ($envs[$kernel->getEnvironment()] ?? $envs['all'] ?? false) {
                $bundlesRegistered[] = $bundleClass;
            }
        }
        $this->assertCount(count($bundlesRegistered), iterator_to_array($kernel->registerBundles()));
    }

    public function testItReturnsTheConfigDir(): void
    {
        $configDir = '/baz';
        $_ENV[DefaultKernel::ENV_CONFIG_DIR_KEY] = $configDir;
        /** @var ScubaDivingKernelInterface $kernel */
        $kernel = self::createKernel();

        $this->assertSame($configDir, $kernel->getConfigDir());
    }
}
