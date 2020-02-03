<?php

declare(strict_types=1);

namespace Shrikeh\Diving\Kit;

use Shrikeh\Diving\Kit\KitBag\Message\KitItemQuery;
use Shrikeh\Diving\Kit\KitBag\QueryBus\ItemQueryBus;

final class KitBag
{
    /** @var ItemQueryBus  */
    private ItemQueryBus $itemQueryBus;

    /**
     * KitBag constructor.
     * @param ItemQueryBus $itemQueryBus
     */
    public function __construct(ItemQueryBus $itemQueryBus)
    {
        $this->itemQueryBus = $itemQueryBus;
    }

    /**
     * @param string $itemName
     * @return Item
     */
    public function getItemDetails(string $itemName): Item
    {
        $itemQuery = KitItemQuery::fromSlug($itemName);

        return $this->itemQueryBus->queryKitItem($itemQuery);
    }
}
