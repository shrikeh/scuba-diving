<?php

declare(strict_types=1);

namespace App\Kit\Repository\Manufacturer;

use App\Kit\Promise\Collection;
use GuzzleHttp\ClientInterface;
use Shrikeh\Diving\Kit\Item\ItemSlug;

final class ManufacturerApi implements ManufacturerRepositoryInterface
{
    /**
     * @var ClientInterface
     */
    private ClientInterface $client;
    /**
     * @var Collection
     */
    private $promiseCollection;

    /**
     * ManufacturerApi constructor.
     * @param ClientInterface $client
     * @param Collection $promiseCollection
     */
    public function __construct(ClientInterface $client, Collection $promiseCollection)
    {
        $this->client = $client;
        $this->promiseCollection = $promiseCollection;
    }

    /**
     * @param ItemSlug $slug
     * @return mixed
     */
    public function fetchBySlug(ItemSlug $slug)
    {
        $promise = $this->client->sendAsync('/item/');
        $this->promiseCollection->wrap($promise, 'FOO');
    }

    /**
     * @param ItemSlug $slug
     * @return mixed
     */
    public function fetchBItemySlug(ItemSlug $slug)
    {
        $promise = $this->client->sendAsync('/item/');
        $this->promiseCollection->wrap($promise, 'FOO');
    }
}
