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

use App\Kernel\BundleLoader\Exception\BundleEnvironmentsNotIterable;
use App\Kernel\BundleLoader\Exception\BundleFileNotExists;
use App\Kernel\BundleLoader\Exception\BundleFileNotReadable;
use App\Kernel\BundleLoader\Exception\BundlesNotIterable;
use App\Kernel\BundleLoader\Exception\InvalidBundleEnvironment;
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
     * @param SplFileInfo|string $path
     * @param string $env
     * @return static
     */
    public static function create($path, string $env): self
    {
        $path = ($path instanceof SplFileInfo) ? $path : new SplFileInfo($path);

        return new self($path, $env);
    }

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
     * @throws \Safe\Exceptions\StringsException
     */
    public function getBundles(): iterable
    {
        $this->assertValidFile();

        $bundles = $this->requireBundles();
        $this->assertValidBundles($bundles);

        return $this->loadBundles($bundles);
    }

    /**
     * @param array<string, array<string>> $bundles
     * @return Generator
     */
    private function loadBundles(array $bundles): Generator
    {
        foreach ($bundles as $class => $envs) {
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
     * Assert that the file is valid
     *
     * @throws BundleFileNotExists
     * @throws BundleFileNotReadable
     * @throws \Safe\Exceptions\StringsException
     */
    private function assertValidFile(): void
    {
        if (!$this->bundlePath->isFile()) {
            throw BundleFileNotExists::fromPath($this->bundlePath->getPath());
        }

        if (!$this->bundlePath->isReadable()) {
            throw BundleFileNotReadable::fromPath($this->bundlePath->getPath());
        }
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
     * @throws \Safe\Exceptions\StringsException
     */
    private function assertValidBundles($bundles): void
    {
        if (!is_iterable($bundles)) {
            throw BundlesNotIterable::create((string) $this->bundlePath);
        }
        foreach ($bundles as $bundle => $envs) {
            if (!is_iterable($envs)) {
                throw BundleEnvironmentsNotIterable::fromBundle($bundle);
            }
            foreach ($envs as $env => $use) {
                if (!(is_string($env) && is_bool($use))) {
                    throw InvalidBundleEnvironment::fromBundleEnv($bundle, $envs);
                }
            }
        }
    }
}
