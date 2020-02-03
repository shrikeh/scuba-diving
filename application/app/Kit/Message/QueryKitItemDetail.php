<?php

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
     * @param string $slug
     */
    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * {@inheritDoc}
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
