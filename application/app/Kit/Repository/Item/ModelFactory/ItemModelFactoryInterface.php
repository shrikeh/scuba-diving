<?php

declare(strict_types=1);

namespace App\Kit\Repository\Item\ModelFactory;

use App\Kit\Model\Item\ItemInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ItemModelFactoryInterface
{
    /**
     * @param ResponseInterface $response
     * @return ItemInterface
     */
    public function createItemFromResponse(ResponseInterface $response): ItemInterface;
}
