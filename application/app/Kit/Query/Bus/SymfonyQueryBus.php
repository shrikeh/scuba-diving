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

namespace App\Kit\Query\Bus;

use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Bus\Exception\IncorrectResultType;
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
     * @throws IncorrectResultType if the result does not match the expected type
     */
    public function queryKitItemDetail(QueryKitItemDetail $queryKitItemDetail): ItemDetail
    {
        $result = $this->handle($queryKitItemDetail);
        $this->assertItemDetail($result);

        return $result;
    }

    /**
     * @param KitItemQuery $kitItemQuery
     * @return Item
     * @throws IncorrectResultType if the result does not match the expected type
     */
    public function queryKitItem(KitItemQuery $kitItemQuery): Item
    {
        $result = $this->handle($kitItemQuery);

        $this->assertItem($result);

        return $result;
    }

    /**
     * @param mixed $result
     * @psalm-assert ItemDetail $result
     */
    private function assertItemDetail($result): void
    {
        if (!$result instanceof ItemDetail) {
            throw IncorrectResultType::fromMessage($result, ItemDetail::class);
        }
    }

    /**
     * @param mixed $result
     * @psalm-assert Item $result
     */
    private function assertItem($result): void
    {
        if (!$result instanceof Item) {
            throw IncorrectResultType::fromMessage($result, Item::class);
        }
    }
}
