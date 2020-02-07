<?php

declare(strict_types=1);

namespace App\Kit\Controller;

use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Bus\ItemDetailQueryBusInterface;
use App\Kit\Query\Result\ItemDetail;

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
     * @param string $kitSlug
     * @return ItemDetail
     */
    public function __invoke(string $slug): ItemDetail
    {
        return $this->queryBus->queryKitItemDetail(new QueryKitItemDetail($slug));
    }
}
