<?php

declare(strict_types=1);

namespace Shrikeh\Diving\Kit\KitBag\Message;

use JsonSerializable;
use Shrikeh\Diving\Kit\Item\ItemSlug;

final class KitItemQuery implements JsonSerializable
{
    public const KEY_KIT_ITEM = 'item_id';

    /** @var ItemSlug */
    private ItemSlug $kitItemId;

    /**
     * @param string $itemSlug
     * @return KitItemQuery
     */
    public static function fromSlug(string $itemSlug): self
    {
        return new self(new ItemSlug($itemSlug));
    }

    /**
     * QueryKitItemQuery constructor.
     * @param ItemSlug $kitItemId
     */
    public function __construct(ItemSlug $kitItemId)
    {
        $this->kitItemId = $kitItemId;
    }

    /**
     * {@inheritDoc}
     * @return array<string>
     */
    public function jsonSerialize(): array
    {
        return [
            self::KEY_KIT_ITEM => (string) $this->kitItemId,
        ];
    }

    /**
     * @return ItemSlug
     */
    public function getKitItemId(): ItemSlug
    {
        return $this->kitItemId;
    }
}
