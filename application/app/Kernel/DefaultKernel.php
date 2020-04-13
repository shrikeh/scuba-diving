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
use App\Kernel\Traits\BaseDirRelativeDirectoriesTrait;
use App\Kernel\Traits\ConfigureContainerTrait;
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
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

use function dirname;

final class DefaultKernel extends Kernel implements
    EnvironmentConfigurableKernelInterface,
    ScubaDivingKernelInterface
{
    use MicroKernelTrait;
    use BaseDirRelativeDirectoriesTrait;
    use ConfigureContainerTrait;
    use EnvironmentConfigurationTrait;

    public const DEFAULT_CONFIG_DIR_NAME = 'config';
    public const DEFAULT_BUNDLE_FILE = 'bundles.php';

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';
    private const TYPE_GLOB = 'glob';

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
     * {@inheritDoc}
     */
    public function getProjectDir(): string
    {
        return dirname(__DIR__, 2);
    }

    /**
     * {@inheritDoc}
     * @throws LoaderLoadException
     * @codeCoverageIgnore
     */
    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $this->importRoutes(
            $routes,
            '%s/{routes}/' . $this->environment . '/*' . self::CONFIG_EXTS,
            '%s/{routes}/*' . self::CONFIG_EXTS,
            '%s/{routes}' . self::CONFIG_EXTS,
        );
    }

    /**
     * {@inheritDoc}
     * @psalm-suppress OverriddenMethodAccess
     */
    private function getDefaultConfigDir(): string
    {
        return sprintf('%s/%s', $this->getProjectDir(), self::DEFAULT_CONFIG_DIR_NAME);
    }

    /**
     * {@inheritDoc}
     * @psalm-suppress OverriddenMethodAccess
     */
    private function getDefaultBundleFile(): string
    {
        return sprintf('%s/%s', $this->getConfigDir(), self::DEFAULT_BUNDLE_FILE);
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
            $routes->import(sprintf($import, $confDir), '/', self::TYPE_GLOB);
        }
    }
}
