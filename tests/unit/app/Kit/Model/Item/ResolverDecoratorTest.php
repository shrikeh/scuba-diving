<?php

declare(strict_types=1);

namespace Tests\Unit\App\Kit\Model\Item;

use App\Kit\Model\Item\ResolverDecorator;
use App\Kit\Model\ModelInterface;
use PHPUnit\Framework\TestCase;

final class ResolverDecoratorTest extends TestCase
{
    public function testItIsAModel(): void
    {
        $closure = \Closure::fromCallable(function() {});

        $item = new ResolverDecorator($closure);

        $this->assertInstanceOf(ModelInterface::class, $item);
    }
}
