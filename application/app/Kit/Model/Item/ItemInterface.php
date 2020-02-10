<?php

declare(strict_types=1);

namespace App\Kit\Model\Item;

use App\Kit\Model\ModelInterface;

interface ItemInterface extends ModelInterface
{
    /**
     * @return string
     */
    public function getName(): string;
}
