<?php

declare(strict_types=1);

namespace App\Kit\Repository\Item;

use App\Kit\Model\Item\ItemInterface;
use Shrikeh\Diving\Kit\Item\ItemSlug;

interface ItemRepositoryInterface
{
    /**
     * @param ItemSlug $slug
     * @return ItemInterface
     */
    public function fetchBySlug(ItemSlug $slug): ItemInterface;
}
