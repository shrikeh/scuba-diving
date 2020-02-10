<?php

declare(strict_types=1);

namespace App\Kit\Model\Item;

final class Item implements ItemInterface
{
    public const KEY_NAME = 'name';

    /**
     * @var
     */
    private string $name;

    /**
     * Item constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): array
    {
        return [
            self::KEY_NAME => $this->getName(),
        ];
    }
}
