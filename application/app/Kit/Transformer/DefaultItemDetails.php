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
