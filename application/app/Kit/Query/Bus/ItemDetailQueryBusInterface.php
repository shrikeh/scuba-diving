<?php

declare(strict_types=1);

namespace App\Kit\Query\Bus;

use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Result\ItemDetail;

interface ItemDetailQueryBusInterface
{
    /**
     * @param QueryKitItemDetail $queryKitItemDetail
     * @return ItemDetail
     */
    public function queryKitItemDetail(QueryKitItemDetail $queryKitItemDetail): ItemDetail;
}
