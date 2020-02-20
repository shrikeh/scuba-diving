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

namespace App\Kit\Repository\Item;

use App\Kit\Model\Item\ItemInterface;
use App\Kit\Repository\Item\ModelFactory\ItemModelFactoryInterface;
use Shrikeh\Diving\Kit\Item\ItemSlug;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use function Safe\sprintf;

final class ItemApi implements ItemRepositoryInterface
{
    public const ITEM_URI = 'item/%s';

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    /**
     * @var ItemModelFactoryInterface
     */
    private ItemModelFactoryInterface $itemFactory;

    /**
     * ItemApi constructor.
     * @param HttpClientInterface $client
     * @param ItemModelFactoryInterface $itemFactory
     */
    public function __construct(
        HttpClientInterface $client,
        ItemModelFactoryInterface $itemFactory
    ) {
        $this->client = $client;
        $this->itemFactory = $itemFactory;
    }

    /**
     * {@inheritDoc}
     * @throws TransportExceptionInterface
     */
    public function fetchBySlug(ItemSlug $slug): ItemInterface
    {
        $response = $this->client->request('GET', $this->createUriFromSlug($slug));

        return $this->itemFactory->createItemFromResponse($response, $slug);
    }

    /**
     * @param ItemSlug $itemSlug
     * @return string
     */
    private function createUriFromSlug(ItemSlug $itemSlug): string
    {
        return sprintf(self::ITEM_URI, $itemSlug->toUuid()->toString());
    }
}
