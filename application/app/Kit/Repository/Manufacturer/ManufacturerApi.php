<?php

declare(strict_types=1);

namespace App\Kit\Repository\Manufacturer;

use App\Kit\Model\Manufacturer\ManufacturerInterface;
use App\Kit\Repository\Manufacturer\ModelFactory\ManufacturerModelFactoryInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Shrikeh\Diving\Kit\Item\ItemSlug;

final class ManufacturerApi implements ManufacturerRepositoryInterface
{
    public const MANUFACTURER_URI = 'item/%s/manufacturer';

    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    /**
     * @var RequestFactoryInterface
     */
    private RequestFactoryInterface $psr7RequestFactory;

    /**
     * @var ManufacturerModelFactoryInterface
     */
    private ManufacturerModelFactoryInterface $manufacturerModelFactory;

    /**
     * ItemApi constructor.
     * @param ClientInterface $client
     * @param RequestFactoryInterface $psr7RequestFactory
     * @param ManufacturerModelFactoryInterface $manufacturerModelFactory
     */
    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $psr7RequestFactory,
        ManufacturerModelFactoryInterface $manufacturerModelFactory
    ) {
        $this->client = $client;
        $this->psr7RequestFactory = $psr7RequestFactory;
        $this->manufacturerModelFactory = $manufacturerModelFactory;
    }

    /**
     * @param ItemSlug $slug
     * @return ManufacturerInterface
     * @throws ClientExceptionInterface
     */
    public function fetchManufacturerByItemSlug(ItemSlug $slug): ManufacturerInterface
    {
        $response = $this->client->sendRequest($this->createRequestFromSlug($slug));

        return $this->manufacturerModelFactory->createManufacturerFromResponse($response);
    }

    /**
     * @param ItemSlug $itemSlug
     * @return RequestInterface
     */
    private function createRequestFromSlug(ItemSlug $itemSlug): RequestInterface
    {
        return $this->psr7RequestFactory->createRequest(
            'GET',
            sprintf(self::MANUFACTURER_URI, $itemSlug->toUuid())
        );
    }
}
