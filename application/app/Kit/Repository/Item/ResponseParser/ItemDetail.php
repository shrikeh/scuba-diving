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

namespace App\Kit\Repository\Item\ResponseParser;

use App\Api\JsonDecoder\JsonDecoderInterface;
use App\Api\ResponseParser\ResponseParserInterface;
use App\Kit\Model\Item\Item;
use App\Kit\Model\Item\ItemInterface;
use App\Kit\Repository\Manufacturer\ResponseParser\Exception\ApiResponse;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
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
     * {@inheritDoc}
     * @return ItemInterface
     * @phan-suppress PhanParamSignatureRealMismatchReturnType Allowable in PHP 7.4
     */
    public function parse(ResponseInterface $response): ItemInterface
    {
        try {
            $content = $response->getContent();
        } catch (ExceptionInterface $e) {
            throw ApiResponse::wrap($e);
        }

        $object = $this->jsonDecoder->decode($content);

        return $this->createItem($object->name);
    }

    /**
     * @param string $name
     * @return Item
     */
    private function createItem(string $name): Item
    {
        return new Item($name);
    }
}
