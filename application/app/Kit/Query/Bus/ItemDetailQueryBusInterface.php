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
use App\Kit\Query\Result\ItemDetail;

interface ItemDetailQueryBusInterface
{
    /**
     * @param QueryKitItemDetail $queryKitItemDetail
     *
     * @return ItemDetail
     */
    public function queryKitItemDetail(QueryKitItemDetail $queryKitItemDetail): ItemDetail;
}
