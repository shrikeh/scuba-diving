<?php

declare(strict_types=1);

namespace App\Kit\Transformer;

use App\Kit\Query\Result\ItemDetail;
use Shrikeh\Diving\Kit\Item;

interface ItemDetailTransformerInterface
{
    /**
     * @param Item $item
     * @return ItemDetail
     */
    public function toItemDetail(Item $item): ItemDetail;
}
