<?php

declare(strict_types=1);

namespace Shrikeh\Diving\Kit\KitBag\QueryBus;

use Shrikeh\Diving\Kit\Item;
use Shrikeh\Diving\Kit\KitBag\Message\KitItemQuery;

interface ItemQueryBus
{
    /**
     * @param KitItemQuery $kitItemQuery
     * @return Item
     */
    public function queryKitItem(KitItemQuery $kitItemQuery): Item;
}
