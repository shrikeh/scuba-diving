<?php

declare(strict_types=1);

namespace App\Kit\Repository\Item\ResponseParser;

use App\Api\JsonDecoder\JsonDecoderInterface;
use App\Api\ResponseParserInterface;
use App\Kit\Model\Item\Item;
use App\Kit\Model\ModelInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ItemDetail implements ResponseParserInterface
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

        return new Item(
            $object->name
        );
    }
}
