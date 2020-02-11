<?php

declare(strict_types=1);

namespace Tests\Unit\App\Kit\Model\Exception;

use App\Kit\Model\Exception\IncorrectModelResolved;
use App\Kit\Model\Item\ItemInterface;
use App\Kit\Model\ModelInterface;
use PHPUnit\Framework\TestCase;

final class IncorrectModelResolvedTest extends TestCase
{
    public function testItIsInstantiatedFromAModel(): void
    {
        $model = $this->prophesize(ModelInterface::class)->reveal();

        $incorrectModelException = IncorrectModelResolved::fromModel(
            $model,
            ItemInterface::class
        );

        $this->assertSame(
            sprintf(IncorrectModelResolved::MSG, ItemInterface::class, get_class($model)),
            $incorrectModelException->getMessage()
        );
    }
}
