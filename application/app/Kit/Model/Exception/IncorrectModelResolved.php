<?php

declare(strict_types=1);

namespace App\Kit\Model\Exception;

use App\Kit\Model\ModelInterface;
use InvalidArgumentException;

final class IncorrectModelResolved extends InvalidArgumentException
{
    public const MSG = 'Expected model of type %s, resolved model was %s';

    /**
     * @param ModelInterface $model
     * @param string $expected
     * @return IncorrectModelResolved
     */
    public static function fromModel(ModelInterface $model, string $expected): self
    {
        return new self(
            sprintf(
                self::MSG,
                $expected,
                get_class($model)
            )
        );
    }
}
