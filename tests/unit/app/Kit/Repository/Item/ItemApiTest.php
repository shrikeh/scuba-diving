<?php

declare(strict_types=1);

namespace Tests\Unit\App\Kit\Repository\Item;

use App\Kit\Model\Item\ItemInterface;
use App\Kit\Repository\Item\ItemApi;
use App\Kit\Repository\Item\ItemFactory\ItemFactoryInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Shrikeh\Diving\Kit\Item\ItemSlug;

final class ItemApiTest extends TestCase
{
    public function testItReturnsAnItem(): void
    {
        $slug = new ItemSlug('some-sort-of-slug');

        $item = $this->prophesize(ItemInterface::class)->reveal();
        $client = $this->prophesize(ClientInterface::class);
        $requestFactory = $this->prophesize(RequestFactoryInterface::class);
        $itemFactory = $this->prophesize(ItemFactoryInterface::class);

        /** @var RequestInterface $request */
        $request = $this->prophesize(RequestInterface::class)->reveal();
        $response = $this->prophesize(ResponseInterface::class);
        $expectedUri = sprintf(ItemApi::ITEM_URI, $slug->toUuid());

        $requestFactory->createRequest('GET', $expectedUri)->willReturn($request);

        $client->sendRequest($request)->willReturn($response);

        $itemFactory->fromResponse($response)->willReturn($item);

        $apiItemRepository = new ItemApi(
            $client->reveal(),
            $requestFactory->reveal(),
            $itemFactory->reveal()
        );

        $this->assertSame($item, $apiItemRepository->fetchBySlug($slug));
    }
}
