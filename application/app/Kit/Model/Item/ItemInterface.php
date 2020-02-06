<?php

declare(strict_types=1);

namespace App\Kit\Model\Item;

interface ItemInterface
{
    /**
     * @return string
     */
    public function getName(): string;
}
