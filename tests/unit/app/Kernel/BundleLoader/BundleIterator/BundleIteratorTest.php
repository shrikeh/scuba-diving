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

namespace Tests\Unit\App\Kernel\BundleLoader\BundleIterator;

use App\Kernel\BundleLoader\BundleIterator\BundleIterator;
use App\Kernel\BundleLoader\BundleIterator\Exception\BundleEnvironmentsNotIterable;
use App\Kernel\BundleLoader\BundleIterator\Exception\InvalidBundleEnvironment;
use PHPUnit\Framework\TestCase;
use Tests\Mock\Bundle\BundleStub;

final class BundleIteratorTest extends TestCase
{
    public function testItThrowsAnExceptionIfTheBundleFileContainsInvalidBundlesEnvs(): void
    {
        $expectedInvalidBundles = [
            BundleStub::class => false,
        ];

        $this->expectExceptionObject(BundleEnvironmentsNotIterable::fromBundle(BundleStub::class));

        BundleIterator::create($expectedInvalidBundles);
    }

    public function testItThrowsAnExceptionIfTheBundleEnvIsNotAString(): void
    {
        $badEnvs = ['no'];
        $expectedInvalidBundles = [
            BundleStub::class => $badEnvs,
        ];

        $this->expectExceptionObject(InvalidBundleEnvironment::fromBundleEnv(BundleStub::class, $badEnvs));

        BundleIterator::create($expectedInvalidBundles);
    }

    public function testItThrowsAnExceptionIfTheBundleEnvIsNotABoolean(): void
    {
        $badEnvs = ['foo' => 'bar'];
        $expectedInvalidBundles = [
            BundleStub::class => $badEnvs,
        ];

        $this->expectExceptionObject(InvalidBundleEnvironment::fromBundleEnv(BundleStub::class, $badEnvs));

        BundleIterator::create($expectedInvalidBundles);
    }
}
