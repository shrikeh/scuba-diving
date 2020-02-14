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

namespace Tests\Unit\App\Kit\Repository\Item\ResponseParser;

use App\Api\JsonDecoder\JsonDecoderInterface;
use App\Kit\Repository\Item\ResponseParser\ItemDetail;
use App\Kit\Model\Item\ItemInterface;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ItemDetailTest extends TestCase
{
    public function testItParsesAnApiResponse(): void
    {
        $body = 'foo';
        $name = 'bar';
        $response = $this->prophesize(ResponseInterface::class);
        $jsonDecoder = $this->prophesize(JsonDecoderInterface::class);

        $json = new stdClass();

        $json->name = $name;

        $response->getContent()->willReturn($body);
        $jsonDecoder->decode($body)->willReturn($json);

        $responseParser = new ItemDetail($jsonDecoder->reveal());

        $item = $responseParser->parse($response->reveal());

        $this->assertInstanceOf(ItemInterface::class, $item);
        $this->assertSame($name, $item->getName());
    }
}
