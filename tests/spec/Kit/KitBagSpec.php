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

namespace spec\Shrikeh\Diving\Kit;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Shrikeh\Diving\Kit\Item;
use Shrikeh\Diving\Kit\KitBag\Message\KitItemQuery;
use Shrikeh\Diving\Kit\KitBag\QueryBus\ItemQueryBus;

final class KitBagSpec extends ObjectBehavior
{
    function let(ItemQueryBus $itemQueryBus): void
    {
        $this->beConstructedWith($itemQueryBus);
    }

    public function it_returns_an_item(ItemQueryBus $itemQueryBus, Item $item): void
    {
        $itemName = 'A titanium knife';
        $itemQueryBus->queryKitItem(Argument::type(KitItemQuery::class))
            ->willReturn($item);

        $this->getItemDetails($itemName)->shouldReturn($item);
    }
}
