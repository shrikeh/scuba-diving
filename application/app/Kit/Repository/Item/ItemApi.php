<?php

declare(strict_types=1);

namespace App\Kit\Repository\Item;

use App\Kit\Model\Item\ItemInterface;
use App\Kit\Repository\Item\PromiseResolver\PromiseResolverFactory;
use GuzzleHttp\ClientInterface;
use Shrikeh\Diving\Kit\Item\ItemSlug;

final class ItemApi implements ItemRepositoryInterface
{
    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    /**
     * @var PromiseResolverFactory
     */
    private $promiseResolverFactory;

    /**
     * ManufacturerApi constructor.
     * @param ClientInterface $client
     * @param PromiseResolverFactory $promiseResolverFactory
     */
    public function __construct(ClientInterface $client, PromiseResolverFactory $promiseResolverFactory)
    {
        $this->client = $client;
        $this->promiseResolverFactory = $promiseResolverFactory;
    }

    /**
     * @param ItemSlug $slug
     * @return mixed
     */
    public function fetchBySlug(ItemSlug $slug): ItemInterface
    {
        $promise = $this->client->sendAsync('/item/');

        $this->promiseResolverFactory->create($promise, 'Foo');
    }
}
