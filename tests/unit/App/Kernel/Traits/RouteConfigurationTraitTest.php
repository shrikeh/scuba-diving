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

use App\Kernel\Traits\RouteConfigurationTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\RouteCollectionBuilder;

final class RouteConfigurationTraitTest extends TestCase
{
    public function testItConfiguresRoutes(): void
    {
        $routes = $this->prophesize(RouteCollectionBuilder::class);
        $routes->import('bar/{routes}/foo/*.{php,xml,yaml,yml}', '/', 'glob')->shouldBeCalledOnce();
        $routes->import('bar/{routes}/*.{php,xml,yaml,yml}', '/', 'glob')->shouldBeCalledOnce();
        $routes->import('bar/{routes}.{php,xml,yaml,yml}', '/', 'glob')->shouldBeCalledOnce();

        $trait = $this->createTraitInstance();

        $trait->configureRoutes($routes->reveal());
    }

    private function createTraitInstance(): object
    {
        return new class() {
            use RouteConfigurationTrait {
                configureRoutes as public;
            }

            private const CONFIG_EXTS = '.{php,xml,yaml,yml}';
            private const TYPE_GLOB = 'glob';

            public function getEnvironment(): string
            {
                return 'foo';
            }

            public function getConfigDir(): string
            {
                return 'bar';
            }
        };
    }
}
