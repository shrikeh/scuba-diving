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

namespace Tests\Unit\App\Kit\Repository\Manufacturer\ResponseParser;

use App\Api\JsonDecoder\JsonDecoderInterface;
use App\Kit\Repository\Manufacturer\ResponseParser\Exception\ApiResponse;
use App\Kit\Repository\Manufacturer\ResponseParser\ItemManufacturer;
use Exception;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ItemManufacturerTest extends TestCase
{
    public function testItReturnsAManufacturer(): void
    {
        $content = 'Some sort of JSON string';
        $name = 'Northern Diver';
        $response = $this->prophesize(ResponseInterface::class);
        $response->getContent()->willReturn($content);
        $jsonDecoder = $this->prophesize(JsonDecoderInterface::class);

        $json = new stdClass();

        $json->name = $name;

        $jsonDecoder->decode($content)->willReturn($json);

        $parser = new ItemManufacturer($jsonDecoder->reveal());

        $manufacturer = $parser->parse($response->reveal());

        $this->assertSame($name, $manufacturer->getName());
    }

    public function testItThrowsAnApiResponseExceptionIfTheResponseFails(): void
    {
        $response = $this->prophesize(ResponseInterface::class);
        $jsonDecoder = $this->prophesize(JsonDecoderInterface::class)->reveal();

        $exception = new TransportException('foo', Response::HTTP_NOT_FOUND);

        $response->getContent()->willThrow($exception);

        $parser = new ItemManufacturer($jsonDecoder);

        $this->expectExceptionObject(ApiResponse::wrap($exception));

        $parser->parse($response->reveal());
    }
}
