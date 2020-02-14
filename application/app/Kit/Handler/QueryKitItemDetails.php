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

use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Result\ItemDetail;
use App\Kit\Transformer\ItemDetailTransformerInterface;
use Shrikeh\Diving\Kit\KitBag;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class QueryKitItemDetails implements MessageHandlerInterface
{
    /** @var KitBag */
    private KitBag $kitBag;
    /**
     * @var ItemDetailTransformerInterface
     */
    private ItemDetailTransformerInterface $itemDetailTransformer;

    /**
     * QueryKitItemDetails constructor.
     * @param KitBag $kitBag
     * @param ItemDetailTransformerInterface $itemDetailTransformer
     */
    public function __construct(
        KitBag $kitBag,
        ItemDetailTransformerInterface $itemDetailTransformer
    ) {
        $this->kitBag = $kitBag;
        $this->itemDetailTransformer = $itemDetailTransformer;
    }

    /**
     * @param QueryKitItemDetail $message
     * @return ItemDetail
     */
    public function __invoke(QueryKitItemDetail $message): ItemDetail
    {
        $item = $this->kitBag->getItemDetails($message->getSlug());

        return $this->itemDetailTransformer->toItemDetail($item);
    }
}
