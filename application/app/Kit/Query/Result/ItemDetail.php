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

namespace App\Kit\Query\Result;

final class ItemDetail
{
    private string $name;

    private string $description;

    private string $text;

    /**
     * ItemManufacturer constructor.
     *
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
