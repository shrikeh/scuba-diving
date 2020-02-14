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

namespace App\Kit\Repository\Manufacturer\ResponseParser;

use App\Api\JsonDecoder\JsonDecoderInterface;
use App\Api\ResponseParserInterface;
use App\Kit\Model\Manufacturer\Manufacturer;
use App\Kit\Model\ModelInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ItemManufacturer implements ResponseParserInterface
{
    /**
     * @var JsonDecoderInterface
     */
    private JsonDecoderInterface $jsonDecoder;

    /**
     * ItemManufacturer constructor.
     * @param JsonDecoderInterface $jsonDecoder
     */
    public function __construct(JsonDecoderInterface $jsonDecoder)
    {
        $this->jsonDecoder = $jsonDecoder;
    }

    /**
     * @param ResponseInterface $response
     * @return ModelInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function parse(ResponseInterface $response): ModelInterface
    {
        $object  = $this->jsonDecoder->decode($response->getContent());

        return new Manufacturer(
            $object->name
        );
    }
}
