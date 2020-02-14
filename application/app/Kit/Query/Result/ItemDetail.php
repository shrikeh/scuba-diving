<?php

declare(strict_types=1);

namespace App\Kit\Query\Result;

final class ItemDetail
{
    private string $name;

    private string $description;

    private string $text;

    /**
     * ItemManufacturer constructor.
     * @param string $name
     * @param string $description
     * @param string $text
     */
    public function __construct(string $name, string $description, string $text)
    {
        $this->name = $name;
        $this->description = $description;
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}
