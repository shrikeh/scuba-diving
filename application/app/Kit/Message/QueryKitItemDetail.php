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

namespace App\Kit\Message;

use JsonSerializable;

final class QueryKitItemDetail implements JsonSerializable
{
    public const KEY_KIT_SLUG = 'slug';

    /** @var string */
    private string $slug;

    /**
     * QueryKitItemDetail constructor.
     *
     * @param string $slug
     */
    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string>
     */
    public function jsonSerialize(): array
    {
        return [
            self::KEY_KIT_SLUG => $this->getSlug(),
        ];
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }
}
