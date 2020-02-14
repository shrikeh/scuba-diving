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

namespace App\Kit\Controller;

use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Bus\ItemDetailQueryBusInterface;
use App\Kit\Query\Result\ItemDetail;

/**
 * Show details of a specific piece of kit
 *
 * Makes a call to the query bus, passing along the slug, and returns an ItemDetail
 *
 * @author Barney Hanlon <barney@shrikeh.net>
 */

final class Item
{
    /** @var ItemDetailQueryBusInterface */
    private ItemDetailQueryBusInterface $queryBus;

    /**
     * SimpleItem constructor.
     * @param ItemDetailQueryBusInterface $queryBus
     */
    public function __construct(ItemDetailQueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @param string $slug
     * @return ItemDetail
     */
    public function __invoke(string $slug): ItemDetail
    {
        return $this->queryBus->queryKitItemDetail(new QueryKitItemDetail($slug));
    }
}
