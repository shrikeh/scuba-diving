<?php

declare(strict_types=1);

namespace App\Kit\Repository\Manufacturer;

use App\Kit\Model\Manufacturer\ManufacturerInterface;
use App\Kit\Repository\Manufacturer\PromiseResolver\PromiseResolverFactoryInterface;
use GuzzleHttp\ClientInterface;
use Shrikeh\Diving\Kit\Item\ItemSlug;

final class ManufacturerApi implements ManufacturerRepositoryInterface
{
    /**
     * @var ClientInterface
     */
    private ClientInterface $client;
    /**
     * @var PromiseResolverFactoryInterface
     */
    private PromiseResolverFactoryInterface $promiseResolverFactory;

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
    public function fetchItemBySlug(ItemSlug $slug): ManufacturerInterface
    {
        $promise = $this->client->requestAsync(
            'GET',
            sprintf('/item/%s/manufacturer', $slug->toSlug())
        );

        return $this->promiseResolverFactory->create($promise, $this->createPromiseKey($slug));
    }


    /**
     * @param ItemSlug $itemSlug
     * @return string
     */
    private function createPromiseKey(ItemSlug $itemSlug): string
    {
        return sprintf('item:manufacturer:%s', $itemSlug->toSlug());
    }
}
