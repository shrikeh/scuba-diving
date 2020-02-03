<?php

declare(strict_types=1);

namespace App\Kit\Controller;


use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Bus\ItemDetailQueryBusInterface;
use App\Kit\Query\Result\ItemDetail;
use Psr\Http\Message\ServerRequestInterface;

final class Item
{
    /** @var ItemDetailQueryBusInterface */
    private ItemDetailQueryBusInterface $queryBus;

    /**
     * Item constructor.
     * @param ItemDetailQueryBusInterface $queryBus
     */
    public function __construct(ItemDetailQueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ItemDetail
     */
    public function __invoke(ServerRequestInterface $request): ItemDetail
    {
        return $this->queryBus->queryKitItemDetail(new QueryKitItemDetail());
    }
}
