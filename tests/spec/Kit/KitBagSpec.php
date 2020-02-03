<?php

declare(strict_types=1);

namespace spec\Shrikeh\Diving\Kit;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Shrikeh\Diving\Kit\Item;
use Shrikeh\Diving\Kit\KitBag\Message\KitItemQuery;
use Shrikeh\Diving\Kit\KitBag\QueryBus\ItemQueryBusInterface;

final class KitBagSpec extends ObjectBehavior
{
    function let(ItemQueryBusInterface $itemQueryBus): void
    {
        $this->beConstructedWith($itemQueryBus);
    }

    public function it_returns_an_item(ItemQueryBusInterface $itemQueryBus): void
    {
        $itemName = 'A titanium knife';
        $item = new Item();
        $itemQueryBus->queryKitItem(Argument::type(KitItemQuery::class))
            ->willReturn($item);

        $this->getItemDetails($itemName)->shouldReturn($item);
    }
}
