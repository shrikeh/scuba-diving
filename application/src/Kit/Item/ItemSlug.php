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

namespace Shrikeh\Diving\Kit\Item;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class ItemSlug
{
    public const OID_ITEM_NAMESPACE = '92af5abe-743c-4edf-b20c-bd4c1307b23a';

    /** @var string */
    private string $slug;

    /**
     * ItemSlug constructor.
     *
     * @param string $slug
     */
    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toUuid()->toString();
    }

    /**
     * @return string
     */
    public function toSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return UuidInterface
     */
    public function toUuid(): UuidInterface
    {
        return Uuid::uuid5(self::OID_ITEM_NAMESPACE, $this->toSlug());
    }
}
