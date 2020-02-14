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
