<?php

declare(strict_types=1);

namespace Tests\Unit\App\Kit\Message;

use App\Kit\Message\QueryKitItemDetail;
use JsonSerializable;
use PHPUnit\Framework\TestCase;

final class QueryKitItemDetailTest extends TestCase
{
    public function testItIsJsonSerializable(): void
    {
        $kitSlug = '5_5_6_5mm-delta-flex-semi-tech-wetsuit';
        $queryMessage = new QueryKitItemDetail($kitSlug);

        $this->assertInstanceOf(JsonSerializable::class, $queryMessage);
        $this->assertSame([QueryKitItemDetail::KEY_KIT_SLUG => $kitSlug], $queryMessage->jsonSerialize());
    }

    public function testItReturnsTheSlug(): void
    {
        $kitSlug = 'some-sort-of-piece-of-kit';
        $queryMessage = new QueryKitItemDetail($kitSlug);

        $this->assertSame($kitSlug, $queryMessage->getSlug());
    }
}
