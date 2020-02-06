<?php

declare(strict_types=1);

namespace App\Kit\Repository\Item;

use App\Kit\Model\Item\ItemInterface;
use App\Kit\Repository\Item\PromiseResolver\PromiseResolverFactory;
use App\Kit\Repository\Item\PromiseResolver\PromiseResolverFactoryInterface;
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
     * @param PromiseResolverFactoryInterface $promiseResolverFactory
     */
    public function __construct(
        ClientInterface $client,
        PromiseResolverFactoryInterface $promiseResolverFactory
    ) {
        $this->client = $client;
        $this->promiseResolverFactory = $promiseResolverFactory;
    }

    /**
     * @param ItemSlug $slug
     * @return mixed
     */
    public function fetchBySlug(ItemSlug $slug): ItemInterface
    {
        $promise = $this->client->requestAsync(
            'GET',
            sprintf('/item/%s', $slug->toUuid())
        );

        return $this->promiseResolverFactory->create($promise, $this->createPromiseKey($slug));
    }

    /**
     * @param ItemSlug $itemSlug
     * @return string
     */
    private function createPromiseKey(ItemSlug $itemSlug): string
    {
        return sprintf('item:%s', $itemSlug->toSlug());
    }
}
