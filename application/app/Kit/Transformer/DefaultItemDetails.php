<?php

declare(strict_types=1);

namespace App\Kit\Transformer;

use App\Kit\Query\Result\ItemDetail;
use Shrikeh\Diving\Kit\Item;

final class DefaultItemDetails implements ItemDetailTransformerInterface
{
    /**
     * @param Item $item
     * @return ItemDetail
     */
    public function toItemDetail(Item $item): ItemDetail
    {
        return new ItemDetail(
            $item->getName(),
            $item->getManufacturer()->getName(),
            $item->getName()
        );
    }
}
