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

namespace App\Kit\Repository\Manufacturer;

use App\Kit\Model\Manufacturer\ManufacturerInterface;
use App\Kit\Repository\Manufacturer\ModelFactory\ManufacturerModelFactoryInterface;
use Safe\Exceptions\StringsException;
use Shrikeh\Diving\Kit\Item\ItemSlug;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use function Safe\sprintf;

final class ManufacturerApi implements ManufacturerRepositoryInterface
{
    public const MANUFACTURER_URI = 'item/%s/manufacturer';

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    /**
     * @var ManufacturerModelFactoryInterface
     */
    private ManufacturerModelFactoryInterface $manufacturerModelFactory;

    /**
     * ItemApi constructor.
     * @param HttpClientInterface $client
     * @param ManufacturerModelFactoryInterface $manufacturerModelFactory
     */
    public function __construct(
        HttpClientInterface $client,
        ManufacturerModelFactoryInterface $manufacturerModelFactory
    ) {
        $this->client = $client;
        $this->manufacturerModelFactory = $manufacturerModelFactory;
    }

    /**
     * @param ItemSlug $slug
     * @return ManufacturerInterface
     * @throws TransportExceptionInterface
     * @throws StringsException
     * @phan-suppress PhanTypeInvalidThrowsIsInterface
     */
    public function fetchManufacturerByItemSlug(ItemSlug $slug): ManufacturerInterface
    {
        $response = $this->client->request('GET', $this->createUriFromSlug($slug));

        return $this->manufacturerModelFactory->createManufacturerFromResponse($response, $slug);
    }

    /**
     * @param ItemSlug $itemSlug
     * @return string
     * @throws StringsException
     */
    private function createUriFromSlug(ItemSlug $itemSlug): string
    {
        return sprintf(self::MANUFACTURER_URI, $itemSlug->toUuid()->toString());
    }
}
