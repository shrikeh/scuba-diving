<?php

declare(strict_types=1);

namespace App\Kit\Repository\Item\ItemFactory;

use App\Kit\Model\Item\ItemInterface;
use Psr\Http\Message\ResponseInterface;

interface ItemFactoryInterface
{
    /**
     * @param ResponseInterface $response
     * @return ItemInterface
     */
    public function fromResponse(ResponseInterface $response): ItemInterface;
}
