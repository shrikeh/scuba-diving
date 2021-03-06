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

namespace App\Kit\Handler;

use App\Kit\Repository\Item\ItemRepositoryInterface;
use App\Kit\Repository\Manufacturer\ManufacturerRepositoryInterface;
use Shrikeh\Diving\Kit\Item;
use App\Kit\Query\Result\SimpleItem;
use Shrikeh\Diving\Kit\KitBag\Message\KitItemQuery;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class QueryKitItem implements MessageHandlerInterface
{
    /**
     * @var ItemRepositoryInterface
     */
    private ItemRepositoryInterface $itemRepository;
    /**
     * @var ManufacturerRepositoryInterface
     */
    private ManufacturerRepositoryInterface $manufacturerRepository;

    /**
     * QueryKitItem constructor.
     * @param ItemRepositoryInterface $itemRepository
     * @param ManufacturerRepositoryInterface $manufacturerRepository
     */
    public function __construct(
        ItemRepositoryInterface $itemRepository,
        ManufacturerRepositoryInterface $manufacturerRepository
    ) {
        $this->itemRepository = $itemRepository;
        $this->manufacturerRepository = $manufacturerRepository;
    }

    /**
     * @param KitItemQuery $kitItemQuery
     * @return Item
     */
    public function __invoke(KitItemQuery $kitItemQuery): Item
    {
        $slug = $kitItemQuery->getKitItemId();

        $itemData = $this->itemRepository->fetchBySlug($slug);
        $manufacturerData = $this->manufacturerRepository->fetchManufacturerByItemSlug($slug);

        return new SimpleItem(
            $itemData,
            $manufacturerData
        );
    }
}
