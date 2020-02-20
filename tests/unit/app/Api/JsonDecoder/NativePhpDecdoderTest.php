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

namespace Tests\Unit\App\Api\JsonDecoder;

use App\Api\JsonDecoder\SafeJsonDecoder;
use PHPUnit\Framework\TestCase;
use SplFileObject;
use Tests\Constants;

final class NativePhpDecdoderTest extends TestCase
{
    public function testItDecodesJson(): void
    {
        $itemBySlug = new SplFileObject(Constants::fixturesDir() . '/json/item_by_slug.json');
        $nativeJsonDecoder = new SafeJsonDecoder();

        $result = $nativeJsonDecoder->decode($itemBySlug->fread($itemBySlug->getSize()));

        $this->assertSame('6c6560b3-56a6-471c-9640-fe3e403d759e', $result->uuid);
        $this->assertSame('othree', $result->product->manufacturer->slug);
    }
}
