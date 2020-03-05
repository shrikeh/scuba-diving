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

namespace App\Kit\Model\Exception;

use App\Kit\Model\ModelInterface;
use InvalidArgumentException;
use Safe\Exceptions\StringsException;

use function Safe\sprintf;

final class IncorrectModelResolved extends InvalidArgumentException
{
    public const MSG = 'Expected model of type %s, resolved model was %s';

    /**
     * @param ModelInterface $model
     * @param string $expected
     * @return IncorrectModelResolved
     * @throws StringsException
     * @SuppressWarnings(PHPMD.StaticAccess) Named constructor pattern
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
