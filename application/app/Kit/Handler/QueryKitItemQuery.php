<?php

declare(strict_types=1);

namespace App\Kit\Handler;

use Shrikeh\Diving\Kit\Item;
use Shrikeh\Diving\Kit\Item\SimpleItem;
use Shrikeh\Diving\Kit\Manufacturer;
use Shrikeh\Diving\Kit\KitBag\Message\KitItemQuery;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class QueryKitItemQuery implements MessageHandlerInterface
{
    /**
     * @param KitItemQuery $kitItemQuery
     * @return Item
     */
    public function __invoke(KitItemQuery $kitItemQuery): Item
    {
        return new SimpleItem(
            'A drysuit',
            new Manufacturer("O'Three")
        );
    }
}
