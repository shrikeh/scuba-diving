<?php

declare(strict_types=1);

namespace Tests\Unit\App\Kit\Repository\Item\ResponseParser;

use App\Api\JsonDeserializerInterface;
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
        $jsonDeserializer = $this->prophesize(JsonDeserializerInterface::class);

        $json = new stdClass();

        $json->name = $name;

        $response->getContent()->willReturn($body);
        $jsonDeserializer->deserialize($body)->willReturn($json);

        $responseParser = new ItemDetail($jsonDeserializer->reveal());

        $item = $responseParser->parse($response->reveal());

        $this->assertInstanceOf(ItemInterface::class, $item);
        $this->assertSame($name, $item->getName());
    }
}
