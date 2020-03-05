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

namespace App\Kernel\BundleLoader\BundleIterator;

use App\Kernel\BundleLoader\BundleIterator\Exception\BundleEnvironmentsNotIterable;
use App\Kernel\BundleLoader\BundleIterator\Exception\BundlesNotIterable;
use App\Kernel\BundleLoader\BundleIterator\Exception\InvalidBundleEnvironment;
use Generator;
use Safe\Exceptions\JsonException;
use Safe\Exceptions\StringsException;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

final class BundleIterator
{
    private iterable $bundles;

    /**
     * @param mixed $bundles
     * @return static
     * @throws StringsException
     * @SuppressWarnings(PHPMD.StaticAccess) Named constructor pattern
     */
    public static function create($bundles): self
    {
        if (!is_iterable($bundles)) {
            throw BundlesNotIterable::create($bundles);
        }

        return new self($bundles);
    }

    /**
     * BundleIterator constructor.
     * @param iterable $bundles
     * @throws StringsException
     */
    private function __construct(iterable $bundles)
    {
        $this->assertValidBundles($bundles);
        $this->bundles = $bundles;
    }

    /**
     * @param string $targetEnv
     * @return Generator
     */
    public function getEnvBundles(string $targetEnv): Generator
    {
        foreach ($this->bundles as $class => $envs) {
            if ($this->isForEnv($targetEnv, $envs)) {
                $bundle = $this->loadBundle($class);
                if ($bundle instanceof BundleInterface) {
                    yield $bundle;
                }
            }
        }
    }

    /**
     * @param string $bundleClass
     * @return BundleInterface|null
     */
    private function loadBundle(string $bundleClass): ?BundleInterface
    {
        if (is_a($bundleClass, BundleInterface::class, true)) {
            return new $bundleClass();
        }

        return null;
    }

    /**
     * @param string $targetEnv
     * @param array $envs
     * @return bool
     */
    private function isForEnv(string $targetEnv, array $envs): bool
    {
        return $envs[$targetEnv] ?? $envs['all'] ?? false;
    }

    /**
     * @param mixed $bundles
     * @psalm-assert array<string, array<string>> $bundles
     * @psalm-suppress MixedAssignment
     * @throws StringsException
     */
    private function assertValidBundles($bundles): void
    {
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
