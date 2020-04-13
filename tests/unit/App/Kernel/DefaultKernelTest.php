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
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\Constants;
use Tests\Unit\Traits\CreateDefaultKernelTrait;

final class DefaultKernelTest extends KernelTestCase
{
    use CreateDefaultKernelTrait;

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
        $this->originalEnv = $_SERVER;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $_SERVER = $this->originalEnv;
    }

    public function testItUsesTheDebugModeFromTheServerVar(): void
    {
        $server['APP_DEBUG'] = false;

        $kernel = static::createKernel($server);
        $this->assertFalse($kernel->isDebug());

        $server['APP_DEBUG'] = true;

        $kernel = static::createKernel($server);
        $this->assertTrue($kernel->isDebug());
    }

    public function testItAllowsExcplicitlySettingTheDebugMode(): void
    {
        $parameterBag = $this->prophesize(ParameterBag::class);
        $parameterBag->get('APP_ENV')->willReturn($_SERVER['APP_ENV']);

        $debug = false;
        $kernel = new DefaultKernel($parameterBag->reveal(), $debug);
        $this->assertFalse($kernel->isDebug());

        $debug = true;
        $kernel = new DefaultKernel($parameterBag->reveal(), $debug);
        $this->assertTrue($kernel->isDebug());
    }

    public function testItReturnsTheProjectDir(): void
    {
        $kernel = static::createKernel();

        $this->assertSame(Constants::appDir(), $kernel->getProjectDir());
    }

    public function testItUsesTheLogDirEnvVar(): void
    {
        $logDir = '/foo';
        $_SERVER[DefaultKernel::ENV_LOG_DIR_KEY] = $logDir;
        $kernel = static::createKernel();

        $this->assertSame($logDir, $kernel->getLogDir());
    }

    public function testItUsesTheCacheDirEnvVar(): void
    {
        $caheDir = '/bar';
        $_SERVER[DefaultKernel::ENV_CACHE_DIR_KEY] = $caheDir;
        $kernel = static::createKernel();

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
        $_SERVER[DefaultKernel::ENV_BUNDLE_FILE_KEY] = $bundlePath;

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
        $_SERVER[DefaultKernel::ENV_CONFIG_DIR_KEY] = $configDir;
        /** @var ScubaDivingKernelInterface $kernel */
        $kernel = static::createKernel();

        $this->assertSame($configDir, $kernel->getConfigDir());
    }
}
