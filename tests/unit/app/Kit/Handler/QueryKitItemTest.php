<?php

declare(strict_types=1);

namespace Tests\Unit\App\Kit\Handler;

use App\Kit\Handler\QueryKitItem;
use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Result\ItemDetail;
use App\Kit\Transformer\ItemDetailTransformerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Shrikeh\Diving\Kit\Item;
use Shrikeh\Diving\Kit\KitBag;
use Shrikeh\Diving\Kit\KitBag\Message\KitItemQuery;
use Shrikeh\Diving\Kit\KitBag\QueryBus\ItemQueryBus;

final class QueryKitItemTest extends TestCase
{
    public function testItQueriesAKitItem(): void
    {
        $slug = 'this-piece-of-kit';
        $queryBus = $this->prophesize(ItemQueryBus::class);
        $transformer = $this->prophesize(ItemDetailTransformerInterface::class);
        $item = $this->prophesize(Item::class);
        $itemDetail = new ItemDetail();

        $queryBus->queryKitItem(Argument::type(KitItemQuery::class))
            ->will(function (array $args) use ($slug, $item) {
                /** @var KitItemQuery $query */
                $query = $args[0];

                $itemId = $query->getKitItemId();

                if ($itemId->toSlug() === $slug) {
                    return $item->reveal();
                }
            });

        $transformer->toItemDetail($item)->willReturn($itemDetail);

        $kitBag = new KitBag($queryBus->reveal());
        $queryMessage = new QueryKitItemDetail($slug);

        $queryHandler = new QueryKitItem($kitBag, $transformer->reveal());

        $this->assertSame($itemDetail, $queryHandler($queryMessage));
    }
}
