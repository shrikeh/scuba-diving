<?php

declare(strict_types=1);

namespace App\Kit\Repository\Manufacturer;

use Shrikeh\Diving\Kit\Item\ItemSlug;

interface ManufacturerRepositoryInterface
{
    /**
     * @param ItemSlug $slug
     * @return mixed
     */
    public function fetchBItemySlug(ItemSlug $slug);
}
