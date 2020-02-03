<?php

declare(strict_types=1);

namespace Tests\Unit\App\Controller;

use App\Kit\Controller\Item;
use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Bus\ItemDetailQueryBusInterface;
use App\Kit\Query\Result\ItemDetail;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\ServerRequestInterface;
use Shrikeh\Diving\Kit\KitBag\Message\KitItemQuery;

final class ItemTest extends TestCase
{
    public function testItReturnsTheItem(): void
    {
        $queryBus = $this->prophesize(ItemDetailQueryBusInterface::class);
        $request = $this->prophesize(ServerRequestInterface::class);

        $itemDetailResult = new ItemDetail();

        $queryBus->queryKitItemDetail(Argument::type(QueryKitItemDetail::class))
            ->willReturn($itemDetailResult);

        $itemAction = new Item($queryBus->reveal());

        $this->assertSame($itemDetailResult, $itemAction($request->reveal()));
    }
}
