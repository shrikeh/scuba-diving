<?php

declare(strict_types=1);

namespace App\Kit\Query\Bus;

use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Result\ItemDetail;
use Shrikeh\Diving\Kit\Item;
use Shrikeh\Diving\Kit\KitBag\Message\KitItemQuery;
use Shrikeh\Diving\Kit\KitBag\QueryBus\ItemQueryBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyQueryBus implements ItemDetailQueryBusInterface, ItemQueryBus
{
    use HandleTrait;

    /**
     * SymfonyQueryBus constructor.
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @param QueryKitItemDetail $queryKitItemDetail
     * @return ItemDetail
     */
    public function queryKitItemDetail(QueryKitItemDetail $queryKitItemDetail): ItemDetail
    {
        return $this->handle($queryKitItemDetail);
    }

    /**
     * @param KitItemQuery $kitItemQuery
     * @return Item
     */
    public function queryKitItem(KitItemQuery $kitItemQuery): Item
    {
        return $this->handle($kitItemQuery);
    }
}
