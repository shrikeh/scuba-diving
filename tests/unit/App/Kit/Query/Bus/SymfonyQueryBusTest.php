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

namespace Tests\Unit\App\Kit\Query\Bus;

use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Bus\Exception\IncorrectResultType;
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
    public function testItAssertsItReceivesBackItemDetails(): void
    {
        $queryKitItemDetailsMsg = new QueryKitItemDetail('some-sort-of-wetsuit');
        $wrongResult = $this->prophesize(Item::class)->reveal();

        $envelope = new Envelope($queryKitItemDetailsMsg, [
            new HandledStamp($wrongResult, 'some-wrong-handler')
        ]);

        $messageBus = $this->prophesize(MessageBusInterface::class);
        $messageBus->dispatch($queryKitItemDetailsMsg)->willReturn($envelope);

        $queryBus = new SymfonyQueryBus($messageBus->reveal());

        $this->expectExceptionObject(IncorrectResultType::fromMessage($wrongResult, ItemDetail::class));

        $queryBus->queryKitItemDetail($queryKitItemDetailsMsg);
    }

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

    public function testItAssertsItReceivesBackAnItem(): void
    {
        $queryKitItemMsg = KitItemQuery::fromSlug('some-sort-of-wetsuit');
        $wrongItem = new ItemDetail('A drysuit', 'A really nice drysuit', 'lorem');


        $envelope = new Envelope($queryKitItemMsg, [
            new HandledStamp($wrongItem, 'some-wrong-handler')
        ]);

        $messageBus = $this->prophesize(MessageBusInterface::class);
        $messageBus->dispatch($queryKitItemMsg)->willReturn($envelope);

        $queryBus = new SymfonyQueryBus($messageBus->reveal());

        $this->expectExceptionObject(IncorrectResultType::fromMessage($wrongItem, Item::class));

        $queryBus->queryKitItem($queryKitItemMsg);
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
