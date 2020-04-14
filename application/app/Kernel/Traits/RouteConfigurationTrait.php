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

use Symfony\Component\Config\Exception\LoaderLoadException;
use Symfony\Component\Routing\RouteCollectionBuilder;

trait RouteConfigurationTrait
{
    /**
     * {@inheritDoc}
     * @throws LoaderLoadException
     * @codeCoverageIgnore
     */
    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $this->importRoutes(
            $routes,
            '%s/{routes}/' . $this->getEnvironment() . '/*' . static::CONFIG_EXTS,
            '%s/{routes}/*' . static::CONFIG_EXTS,
            '%s/{routes}' . static::CONFIG_EXTS
        );
    }

    /**
     * @param RouteCollectionBuilder $routes
     * @param string ...$imports
     * @throws LoaderLoadException
     */
    private function importRoutes(RouteCollectionBuilder $routes, string ...$imports): void
    {
        $confDir = $this->getConfigDir();
        foreach ($imports as $import) {
            $routes->import(sprintf($import, $confDir), '/', static::TYPE_GLOB);
        }
    }
}
