<?php

declare(strict_types=1);

namespace Tests\Unit\App\Kit\Repository\Item;

use App\Kit\Model\Item\ItemInterface;
use App\Kit\Repository\Item\ItemApi;
use App\Kit\Repository\Item\PromiseResolver\PromiseResolverFactoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Shrikeh\Diving\Kit\Item\ItemSlug;

final class ItemApiTest extends TestCase
{
    public function testItReturnsAnItem(): void
    {
        $slug = new ItemSlug('some-sort-of-slug');

        $expectedUri = sprintf('/item/%s', $slug->toUuid());

        $item = $this->prophesize(ItemInterface::class)->reveal();
        $promiseResolverFactory = $this->prophesize(PromiseResolverFactoryInterface::class);
        $client = $this->prophesize(ClientInterface::class);
        $promise = $this->prophesize(PromiseInterface::class)->reveal();

        $client->requestAsync('GET', $expectedUri)->willReturn($promise);

        $promiseResolverFactory->create(
            $promise,
            Argument::containingString($slug->toSlug())
        )->willReturn($item);

        $apiItemRepository = new ItemApi(
            $client->reveal(),
            $promiseResolverFactory->reveal()
        );

        $this->assertSame($item, $apiItemRepository->fetchBySlug($slug));
    }
}
