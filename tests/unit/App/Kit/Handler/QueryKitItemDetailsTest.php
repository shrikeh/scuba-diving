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

use App\Kit\Handler\QueryKitItemDetails;
use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Result\ItemDetail;
use App\Kit\Transformer\ItemDetailTransformerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Shrikeh\Diving\Kit\Item;
use Shrikeh\Diving\Kit\KitBag;
use Shrikeh\Diving\Kit\KitBag\Message\KitItemQuery;
use Shrikeh\Diving\Kit\KitBag\QueryBus\ItemQueryBus;

final class QueryKitItemDetailsTest extends TestCase
{
    public function testItReturnsItemDetails(): void
    {
        $slug = 'this-piece-of-kit';
        $queryBus = $this->prophesize(ItemQueryBus::class);
        $transformer = $this->prophesize(ItemDetailTransformerInterface::class);
        $item = $this->prophesize(Item::class);
        $itemDetailResult = new ItemDetail('A drysuit', 'A really nice drysuit', 'lorem');

        $queryBus->queryKitItem(Argument::type(KitItemQuery::class))
            ->will(function (array $args) use ($slug, $item) {
                /** @var KitItemQuery $query */
                $query = $args[0];

                $itemId = $query->getKitItemId();

                if ($itemId->toSlug() === $slug) {
                    return $item->reveal();
                }
            });

        $transformer->toItemDetail($item)->willReturn($itemDetailResult);

        $kitBag = new KitBag($queryBus->reveal());
        $queryMessage = new QueryKitItemDetail($slug);

        $queryHandler = new QueryKitItemDetails($kitBag, $transformer->reveal());

        $this->assertSame($itemDetailResult, $queryHandler($queryMessage));
    }
}
