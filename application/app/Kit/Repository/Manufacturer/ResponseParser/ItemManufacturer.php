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
use App\Api\ResponseParser\ResponseParserInterface;
use App\Kit\Model\Manufacturer\Manufacturer;
use App\Kit\Model\Manufacturer\ManufacturerInterface;
use App\Kit\Repository\Manufacturer\ResponseParser\Exception\ApiResponse;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
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
     * {@inheritDoc}
     * @return ManufacturerInterface
     */
    public function parse(ResponseInterface $response): ManufacturerInterface
    {
        try {
            $content = $response->getContent();
        } catch (ExceptionInterface $e) {
            throw ApiResponse::wrap($e);
        }

        $object = $this->jsonDecoder->decode($content);

        return $this->buildManufacturer($object->name);
    }

    /**
     * @param string $name
     * @return Manufacturer
     */
    private function buildManufacturer(string $name): Manufacturer
    {
        return new Manufacturer($name);
    }
}
