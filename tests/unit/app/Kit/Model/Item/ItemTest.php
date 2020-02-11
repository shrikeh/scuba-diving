<?php

declare(strict_types=1);

namespace Tests\Unit\App\Kit\Model\Item;

use App\Kit\Model\Item\Item;
use App\Kit\Model\ModelInterface;
use JsonSerializable;
use PHPUnit\Framework\TestCase;

final class ItemTest extends TestCase
{
    public function testItIsAModel(): void
    {
        $name = 'Foo';
        $item = new Item($name);

        $this->assertInstanceOf(ModelInterface::class, $item);
    }

    public function testItIsJsonSerializable(): void
    {
        $name = 'Foo';
        $item = new Item($name);

        $this->assertInstanceOf(JsonSerializable::class, $item);

        $json = json_decode(json_encode($item));

        $this->assertSame($name, $json->name);
    }
}