<?php

declare(strict_types=1);

namespace App\Kit\Model\Item;

use JsonSerializable;

interface ItemInterface extends JsonSerializable
{
    /**
     * @return string
     */
    public function getName(): string;
}