<?php

declare(strict_types=1);

namespace Shrikeh\Diving\Kit;

use Shrikeh\Diving\Kit\KitBag\Message\KitItemQuery;
use Shrikeh\Diving\Kit\KitBag\QueryBus\ItemQueryBusInterface;

final class KitBag
{
    /** @var ItemQueryBusInterface  */
    private ItemQueryBusInterface $itemQueryBus;

    /**
     * KitBag constructor.
     * @param $itemQueryBus
     */
    public function __construct(ItemQueryBusInterface $itemQueryBus)
    {
        $this->itemQueryBus = $itemQueryBus;
    }

    /**
     * @param string $itemName
     * @return Item
     */
    public function getItemDetails(string $itemName): Item
    {
        $itemQuery = new KitItemQuery();

        return $this->itemQueryBus->queryKitItem($itemQuery);
    }
}
