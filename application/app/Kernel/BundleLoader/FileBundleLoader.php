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

use App\Kernel\BundleLoader\BundleIterator\BundleIterator;
use App\Kernel\BundleLoader\BundleIterator\Exception\BundleIteratorExceptionInterface;
use App\Kernel\BundleLoader\Exception\BundleFileNotExists;
use App\Kernel\BundleLoader\Exception\BundleFileNotReadable;
use App\Kernel\BundleLoader\Exception\BundleRealpathFalse;
use App\Kernel\BundleLoader\Exception\BundlesNotLoadable;
use Safe\Exceptions\StringsException;
use Shrikeh\File\File;
use SplFileInfo;

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
     * @var BundleIterator
     * @psalm-suppress PropertyNotSetInConstructor We need $bundles to be lazily set, as we get it on demand.
     */
    private BundleIterator $bundles;

    /**
     * @var bool
     */
    private bool $loaded = false;

    /**
     * @param SplFileInfo|string $path
     * @param string $env
     * @return static
     * @SuppressWarnings(PHPMD.StaticAccess) Named constructor pattern
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
     * @throws StringsException
     */
    public function getBundles(): iterable
    {
        return $this->getBundleIterator()->getEnvBundles($this->targetEnv);
    }

    /**
     * Assert that the file is valid
     *
     * @throws BundleFileNotExists
     * @throws BundleFileNotReadable
     * @throws StringsException
     * @return string
     */
    private function getBundlePath(): string
    {
        if (!$this->bundlePath->isFile()) {
            throw BundleFileNotExists::fromPath($this->bundlePath->getPathname());
        }

        if (!$this->bundlePath->isReadable()) {
            throw BundleFileNotReadable::fromPath($this->bundlePath->getPathname());
        }

        if (!$path = $this->bundlePath->getRealPath()) {
            throw BundleRealpathFalse::create($this->bundlePath);
        }

        return $path;
    }

    /**
     * @return mixed
     * @throws StringsException
     */
    private function requireBundles()
    {
        return File::require($this->getBundlePath());
    }

    /**
     * @return BundleIterator
     * @throws StringsException
     */
    private function getBundleIterator(): BundleIterator
    {
        if (!$this->loaded) {
            $bundles = $this->requireBundles();
            try {
                $this->bundles = BundleIterator::create($bundles);
            } catch (BundleIteratorExceptionInterface $e) {
                throw BundlesNotLoadable::fromBundleIteratorException($e, $this->bundlePath->getPath());
            }
            $this->loaded = true;
        }

        return $this->bundles;
    }
}
