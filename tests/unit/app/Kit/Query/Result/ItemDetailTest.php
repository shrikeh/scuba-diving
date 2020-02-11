<?php

declare(strict_types=1);

namespace Tests\Unit\App\Kit\Query\Result;

use App\Kit\Query\Result\ItemDetail;
use PHPUnit\Framework\TestCase;

final class ItemDetailTest extends TestCase
{
    public function testItReturnsTheName(): void
    {
        $name = 'Foo Bar Baz';
        $description = 'Some description';
        $text = 'Lorem ipsum';

        $itemDetail = new ItemDetail($name, $description, $text);

        $this->assertSame($name, $itemDetail->getName());
    }

    public function testItReturnsTheDescription(): void
    {
        $name = 'Foo Bar Baz';
        $description = 'Some description';
        $text = 'Lorem ipsum';

        $itemDetail = new ItemDetail($name, $description, $text);

        $this->assertSame($description, $itemDetail->getDescription());
    }

    public function testItReturnsTheText(): void
    {
        $name = 'Foo Bar Baz';
        $description = 'Some description';
        $text = 'Lorem ipsum';

        $itemDetail = new ItemDetail($name, $description, $text);

        $this->assertSame($text, $itemDetail->getText());
    }
}
