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

namespace Tests\Unit\App\Kit\Handler;

use App\Kit\Handler\QueryKitItem;
use App\Kit\Model\Item\ItemInterface;
use App\Kit\Model\Manufacturer\ManufacturerInterface;
use App\Kit\Query\Result\SimpleItem;
use App\Kit\Repository\Item\ItemRepositoryInterface;
use App\Kit\Repository\Manufacturer\ManufacturerRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Shrikeh\Diving\Kit\KitBag\Message\KitItemQuery;

final class QueryKitItemTest extends TestCase
{
    public function testItQueriesAKitItem(): void
    {
        $slug = 'this-piece-of-kit';

        $kitItemQuery = KitItemQuery::fromSlug($slug);
        $itemModel = $this->prophesize(ItemInterface::class);
        $manufacturerModel = $this->prophesize(ManufacturerInterface::class);
        $itemRepository = $this->prophesize(ItemRepositoryInterface::class);
        $itemRepository->fetchBySlug($kitItemQuery->getKitItemId())->willReturn($itemModel->reveal());

        $manufacturerRepository = $this->prophesize(ManufacturerRepositoryInterface::class);
        $manufacturerRepository->fetchManufacturerByItemSlug($kitItemQuery->getKitItemId())->willReturn(
            $manufacturerModel->reveal()
        );

        $itemModel->getName()->willReturn('Zis thing');
        $manufacturerModel->getName()->willReturn('Zat manufacturer');

        $handler = new QueryKitItem($itemRepository->reveal(), $manufacturerRepository->reveal());

        $result = $handler($kitItemQuery);

        $this->assertInstanceOf(SimpleItem::class, $result);
    }
}
