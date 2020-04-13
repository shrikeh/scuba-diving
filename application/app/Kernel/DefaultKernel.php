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

namespace App\Kernel;

use App\Kernel\BundleLoader\FileBundleLoader;
use App\Kernel\Traits\EnvironmentConfigurationTrait;
use Exception;
use Safe\Exceptions\StringsException;
use SplFileInfo;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Exception\LoaderLoadException;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

use function dirname;

final class DefaultKernel extends BaseKernel implements
    EnvironmentConfigurableKernelInterface,
    ScubaDivingKernelInterface
{
    use MicroKernelTrait;

    /**
     * Change the visibility on these inherited methods, the only reason they are protected is because a trait cannot
     * define an abstract private method.
     */
    use EnvironmentConfigurationTrait {
        getDefaultBundleFile as private;
        getDefaultCacheDir as private;
        getDefaultConfigDir as private;
        getDefaultLogDir as private;
    }

    public const DEFAULT_CONFIG_DIR_NAME = 'config';
    public const DEFAULT_BUNDLE_FILE = 'bundles.php';

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    /**
     * @param array $server
     * @return static
     */
    public static function fromArray(array $server): self
    {
        return new self(
            new ParameterBag($server)
        );
    }

    /**
     * DefaultKernel constructor.
     * @param ParameterBag $serverBag
     * @param bool|null $debug
     */
    public function __construct(ParameterBag $serverBag, bool $debug = null)
    {
        $debug = $debug ?? $serverBag->getBoolean('APP_DEBUG');
        $this->serverBag = $serverBag;

        parent::__construct($serverBag->get('APP_ENV'), $debug);
    }


    /**
     * @return iterable
     * @throws StringsException
     */
    public function registerBundles(): iterable
    {
        $bundleConfig = new SplFileInfo($this->getBundleFile());
        $bundleLoader = new FileBundleLoader($bundleConfig, $this->environment);

        yield from $bundleLoader->getBundles();
    }

    /**
     * @return string
     */
    public function getProjectDir(): string
    {
        return dirname(__DIR__, 2);
    }

    /**
     * @param ContainerBuilder $container
     * @param LoaderInterface $loader
     * @throws Exception
     * @codeCoverageIgnore
     */
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->addResource(new FileResource($this->getBundleFile()));
        $container->setParameter('container.dumper.inline_class_loader', \PHP_VERSION_ID < 70400 || $this->debug);
        $container->setParameter('container.dumper.inline_factories', true);

        $confDir = $this->getConfigDir();

        $loader->load($confDir . '/{packages}/*' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{packages}/' . $this->environment . '/*' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{services}' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{services}_' . $this->environment . self::CONFIG_EXTS, 'glob');
    }

    /**
     * {@inheritDoc}
     * @throws LoaderLoadException
     * @codeCoverageIgnore
     */
    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getConfigDir();

        $routes->import($confDir . '/{routes}/' . $this->environment . '/*' . self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir . '/{routes}/*' . self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir . '/{routes}' . self::CONFIG_EXTS, '/', 'glob');
    }

    /**
     * Workaround for traits not using parent::()
     * {@inheritDoc}
     */
    private function getDefaultCacheDir(): string
    {
        return parent::getCacheDir();
    }

    /**
     * Workaround for traits not using parent::()
     * {@inheritDoc}
     * @psalm-suppress TraitMethodSignatureMismatch
     */
    private function getDefaultLogDir(): string
    {
        return parent::getLogDir();
    }

    /**
     * {@inheritDoc}
     * @psalm-suppress TraitMethodSignatureMismatch
     */
    private function getDefaultConfigDir(): string
    {
        return sprintf('%s/%s', $this->getProjectDir(), self::DEFAULT_CONFIG_DIR_NAME);
    }

    /**
     * {@inheritDoc}
     */
    private function getDefaultBundleFile(): string
    {
        return sprintf('%s/%s', $this->getConfigDir(), self::DEFAULT_BUNDLE_FILE);
    }
}
