<?php

declare(strict_types=1);

namespace Tests\Unit\App\Kit\Query\Bus;

use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Bus\ItemDetailQueryBusInterface;
use App\Kit\Query\Bus\SymfonyQueryBus;
use App\Kit\Query\Result\ItemDetail;
use PHPUnit\Framework\TestCase;
use Shrikeh\Diving\Kit\Item;
use Shrikeh\Diving\Kit\KitBag\Message\KitItemQuery;
use Shrikeh\Diving\Kit\KitBag\QueryBus\ItemQueryBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class SymfonyQueryBusTest extends TestCase
{
    public function testItReturnsItemDetails(): void
    {
        $queryKitItemDetailsMsg = new QueryKitItemDetail('some-sort-of-wetsuit');
        $itemDetailResult = new ItemDetail('A drysuit', 'A really nice drysuit', 'lorem');
        $envelope = new Envelope($queryKitItemDetailsMsg, [
            new HandledStamp($itemDetailResult, 'some-handler')
        ]);

        $messageBus = $this->prophesize(MessageBusInterface::class);

        $messageBus->dispatch($queryKitItemDetailsMsg)->willReturn($envelope);

        $queryBus = new SymfonyQueryBus($messageBus->reveal());

        $this->assertInstanceOf(ItemDetailQueryBusInterface::class, $queryBus);

        $this->assertSame($itemDetailResult, $queryBus->queryKitItemDetail($queryKitItemDetailsMsg));
    }

    public function testItReturnsItems(): void
    {
        $queryKitItemMsg = KitItemQuery::fromSlug('some-sort-of-wetsuit');
        $item = $this->prophesize(Item::class)->reveal();


        $envelope = new Envelope($queryKitItemMsg, [
            new HandledStamp($item, 'some-handler')
        ]);

        $messageBus = $this->prophesize(MessageBusInterface::class);
        $messageBus->dispatch($queryKitItemMsg)->willReturn($envelope);

        $queryBus = new SymfonyQueryBus($messageBus->reveal());

        $this->assertInstanceOf(ItemQueryBus::class, $queryBus);

        $this->assertSame($item, $queryBus->queryKitItem($queryKitItemMsg));
    }
}
