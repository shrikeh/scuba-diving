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

namespace App\Kernel\BundleLoader;

use Generator;
use SplFileInfo;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

final class FileBundleLoader
{
    /**
     * @var SplFileInfo
     */
    private SplFileInfo $bundlePath;
    /**
     * @var string
     */
    private string $targetEnv;

    /**
     * FileBundleLoader constructor.
     * @param SplFileInfo $bundlePath
     * @param string $targetEnv
     */
    public function __construct(SplFileInfo $bundlePath, string $targetEnv)
    {
        $this->bundlePath = $bundlePath;
        $this->targetEnv = $targetEnv;
    }

    /**
     * @return iterable
     */
    public function getBundles(): iterable
    {
        if (!$this->isValidPath()) {
            // throw something here
        }

        $bundles = $this->requireBundles();
        $this->assertValidBundles($bundles);

        yield from $this->loadBundles($bundles);
    }

    /**
     * @param array<string, array<string>> $bundles
     * @return Generator
     */
    private function loadBundles(array $bundles): Generator
    {
        foreach ($bundles as $class => $envs) {
            /** @var BundleInterface|null $bundle */
            $bundle = $this->initEnvBundle($class, $envs);
            if ($bundle instanceof BundleInterface) {
                yield $bundle;
            }
        }
    }

    /**
     * @param string $class
     * @param array $envs
     * @return BundleInterface|null
     */
    private function initEnvBundle(string $class, array $envs): ?BundleInterface
    {
        if ($envs[$this->targetEnv] ?? $envs['all'] ?? false) {
            if (is_a($class, BundleInterface::class, true)) {
                return new $class();
            }
        }

        return null;
    }

    /**
     * @return bool
     */
    private function isValidPath(): bool
    {
        return $this->bundlePath->isFile() && $this->bundlePath->isReadable();
    }

    /**
     * @return mixed
     * @psalm-suppress UnresolvableInclude In Fabien we trust
     */
    private function requireBundles()
    {
        return require $this->bundlePath->getRealPath();
    }

    /**
     * @param mixed $bundles
     * @psalm-assert array<string, array<string>> $bundles
     * @psalm-suppress MixedAssignment
     */
    private function assertValidBundles($bundles): void
    {
        if (is_array($bundles)) {
            // some exception
        }
        foreach ($bundles as $envs) {
            if (!is_array($envs)) {
                // some other exception
            }
            foreach ($envs as $env) {
                if (!is_string($env)) {
                    // another one here
                }
            }
        }
    }
}
