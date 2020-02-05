<?php

declare(strict_types=1);

namespace Tests\Unit\App\Kit\Controller;

use App\Kit\Controller\Item;
use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Bus\ItemDetailQueryBusInterface;
use App\Kit\Query\Result\ItemDetail;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

final class ItemTest extends TestCase
{
    public function testItReturnsTheItem(): void
    {
        $kitSlug = 'some-sort-of-drysuit-slug';
        $queryBus = $this->prophesize(ItemDetailQueryBusInterface::class);

        $itemDetailResult = new ItemDetail('A drysuit', 'A really nice drysuit', 'lorem');

        $queryBus->queryKitItemDetail(Argument::type(QueryKitItemDetail::class))
            ->willReturn($itemDetailResult);

        $itemAction = new Item($queryBus->reveal());

        $this->assertSame($itemDetailResult, $itemAction($kitSlug));
    }
}
