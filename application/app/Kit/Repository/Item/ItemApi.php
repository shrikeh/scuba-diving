<?php

declare(strict_types=1);

namespace App\Kit\Repository\Item;

use App\Kit\Model\Item\ItemInterface;
use App\Kit\Repository\Item\ItemFactory\ItemFactoryInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Shrikeh\Diving\Kit\Item\ItemSlug;

final class ItemApi implements ItemRepositoryInterface
{
    public const ITEM_URI = 'item/%s';

    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    /**
     * @var RequestFactoryInterface
     */
    private $psr7RequestFactory;
    /**
     * @var ItemFactoryInterface
     */
    private $itemFactory;

    /**
     * ManufacturerApi constructor.
     * @param ClientInterface $client
     * @param RequestFactoryInterface $psr7RequestFactory
     * @param ItemFactoryInterface $itemFactory
     */
    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $psr7RequestFactory,
        ItemFactoryInterface $itemFactory
    ) {
        $this->client = $client;
        $this->psr7RequestFactory = $psr7RequestFactory;
        $this->itemFactory = $itemFactory;
    }

    /**
     * @param ItemSlug $slug
     * @return ItemInterface
     * @throws ClientExceptionInterface
     */
    public function fetchBySlug(ItemSlug $slug): ItemInterface
    {
        $response = $this->client->sendRequest($this->createRequestFromSlug($slug));

        return $this->itemFactory->fromResponse($response);
    }


    /**
     * @param ItemSlug $itemSlug
     * @return RequestInterface
     */
    private function createRequestFromSlug(ItemSlug $itemSlug): RequestInterface
    {
        return $this->psr7RequestFactory->createRequest(
            'GET',
            sprintf(self::ITEM_URI, $itemSlug->toUuid())
        );
    }
}
