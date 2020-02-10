<?php

declare(strict_types=1);

namespace App\Kit\Model\Exception;

use App\Kit\Model\ModelInterface;
use InvalidArgumentException;

final class IncorrectModelResolved extends InvalidArgumentException
{
    /**
     * @param ModelInterface $model
     * @param string $expected
     * @return IncorrectModelResolved
     */
    public static function fromModel(ModelInterface $model, string $expected): self
    {
        return new self(
            sprintf(
                'Expected model of type %s, resolved model was %s',
                $expected,
                get_class($model)
            )
        );
    }
}
