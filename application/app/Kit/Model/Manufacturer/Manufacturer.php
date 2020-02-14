<?php

declare(strict_types=1);

namespace App\Kit\Model\Manufacturer;

final class Manufacturer implements ManufacturerInterface
{
    public const KEY_NAME = 'name';

    /**
     * @var string
     */
    private string $name;

    /**
     * Item constructor.
     * @param string $name
     */
    public function __construct(string $name)
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
