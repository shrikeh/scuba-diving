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

use App\Kernel\Traits\ContainerConfigurationTrait;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Loader\LoaderInterface;
use Tests\Constants;

final class ContainerConfigurationTraitTest extends TestCase
{
    public function testItConfiguresAContainer(): void
    {
        $containerBuilder = $this->prophesize(ContainerBuilder::class);
        $loader = $this->prophesize(LoaderInterface::class);

        $containerBuilder->addResource(Argument::type(FileResource::class))->shouldBeCalledOnce();
        $containerBuilder->setParameter('container.dumper.inline_class_loader', true)->shouldBeCalledOnce();
        $containerBuilder->setParameter('container.dumper.inline_factories', true)->shouldBeCalledOnce();
        $loader->load('bar/{packages}/*.{php,xml,yaml,yml}', 'glob')->shouldBeCalledOnce();
        $loader->load('bar/{packages}/foo/*.{php,xml,yaml,yml}', 'glob')->shouldBeCalledOnce();
        $loader->load('bar/{services}.{php,xml,yaml,yml}', 'glob')->shouldBeCalledOnce();
        $loader->load('bar/{services}_foo.{php,xml,yaml,yml}', 'glob')->shouldBeCalledOnce();

        $trait = $this->createTraitInstance();

        $trait->configureContainer($containerBuilder->reveal(), $loader->reveal());
    }

    private function createTraitInstance(): object
    {
        return new class() {
            use ContainerConfigurationTrait {
                configureContainer as public;
            }

            private const CONFIG_EXTS = '.{php,xml,yaml,yml}';
            private const TYPE_GLOB = 'glob';

            public function getBundleFile(): string
            {
                return Constants::fixturesDir() . '/config/GoodMixedBundles.php';
            }

            public function getEnvironment(): string
            {
                return 'foo';
            }

            public function getConfigDir(): string
            {
                return 'bar';
            }

            public function isDebug(): bool
            {
                return true;
            }
        };
    }
}
