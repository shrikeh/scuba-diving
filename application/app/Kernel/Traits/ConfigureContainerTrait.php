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

use Exception;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;

trait ConfigureContainerTrait
{
    /**
     * @param ContainerBuilder $container
     * @param LoaderInterface $loader
     * @throws Exception
     * @codeCoverageIgnore
     */
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->addResource(new FileResource($this->getBundleFile()));
        $container->setParameter(
            'container.dumper.inline_class_loader',
            \PHP_VERSION_ID < 70400 || $this->isDebug()
        );
        $container->setParameter('container.dumper.inline_factories', true);

        $environment = $this->getEnvironment();

        $this->configureContainerLoader(
            $loader,
            '%s/{packages}/*' . self::CONFIG_EXTS,
            '%s/{packages}/' . $environment . '/*' . self::CONFIG_EXTS,
            '%s/{services}' . self::CONFIG_EXTS,
            '%s/{services}_' . $environment . self::CONFIG_EXTS
        );
    }

    /**
     * @param LoaderInterface $loader
     * @param string ...$imports
     * @throws Exception
     */
    private function configureContainerLoader(LoaderInterface $loader, string ...$imports): void
    {
        $confDir = $this->getConfigDir();
        foreach ($imports as $import) {
            $loader->load(sprintf($import, $confDir), self::TYPE_GLOB);
        }
    }

    /**
     * @return bool
     */
    abstract public function isDebug();

    /**
     * @return string
     */
    abstract public function getEnvironment();
}
