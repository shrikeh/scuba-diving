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

namespace Tests\Unit\App\Kit\Repository\Manufacturer;

use App\Kit\Model\Manufacturer\ManufacturerInterface;
use App\Kit\Repository\Manufacturer\ManufacturerApi;
use App\Kit\Repository\Manufacturer\ModelFactory\ManufacturerModelFactoryInterface;
use PHPUnit\Framework\TestCase;
use Shrikeh\Diving\Kit\Item\ItemSlug;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

use function Safe\sprintf;

final class ManufacturerApiTest extends TestCase
{
    public function testItReturnsAManufacturerFromAnItemSlug(): void
    {
        $slug = new ItemSlug('some-sort-of-slug');

        $manufacturer = $this->prophesize(ManufacturerInterface::class)->reveal();
        $client = $this->prophesize(HttpClientInterface::class);
        $manufacturerFactory = $this->prophesize(ManufacturerModelFactoryInterface::class);

        $response = $this->prophesize(ResponseInterface::class);
        $expectedUri = sprintf(ManufacturerApi::MANUFACTURER_URI, $slug->toUuid());

        $client->request('GET', $expectedUri)->willReturn($response);

        $manufacturerFactory->createManufacturerFromResponse($response, $slug)->willReturn($manufacturer);

        $apiManufacturerRepository = new ManufacturerApi(
            $client->reveal(),
            $manufacturerFactory->reveal()
        );

        $this->assertSame($manufacturer, $apiManufacturerRepository->fetchManufacturerByItemSlug($slug));
    }
}
