<?php

declare(strict_types=1);

namespace Tests\Unit\App\Kit\Repository\Item;

use App\Kit\Model\Item\ItemInterface;
use App\Kit\Repository\Item\ItemApi;
use App\Kit\Repository\Item\ModelFactory\ItemModelFactoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Shrikeh\Diving\Kit\Item\ItemSlug;

final class ItemApiTest extends TestCase
{
    public function testItReturnsAnItem(): void
    {
        $slug = new ItemSlug('some-sort-of-slug');

        $item = $this->prophesize(ItemInterface::class)->reveal();
        $client = $this->prophesize(HttpClientInterface::class);
        $itemFactory = $this->prophesize(ItemModelFactoryInterface::class);

        $response = $this->prophesize(ResponseInterface::class);
        $expectedUri = sprintf(ItemApi::ITEM_URI, $slug->toUuid());

        $client->request('GET', $expectedUri)->willReturn($response);

        $itemFactory->createItemFromResponse($response)->willReturn($item);

        $apiItemRepository = new ItemApi(
            $client->reveal(),
            $itemFactory->reveal()
        );

        $this->assertSame($item, $apiItemRepository->fetchBySlug($slug));
    }
}
