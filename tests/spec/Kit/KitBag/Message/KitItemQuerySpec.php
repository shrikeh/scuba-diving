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

namespace spec\Shrikeh\Diving\Kit\KitBag\Message;

use JsonSerializable;
use PhpSpec\ObjectBehavior;
use Shrikeh\Diving\Kit\Item\ItemSlug;
use Shrikeh\Diving\Kit\KitBag\Message\KitItemQuery;

final class KitItemQuerySpec extends ObjectBehavior
{
    public function getMatchers(): array
    {
        return [
            'matchItemSlug' => static function (ItemSlug $actual, string $slug): bool {
                $expected = new ItemSlug($slug);

                return $expected->toUuid()->equals($actual->toUuid());
            },
        ];
    }

    public function it_returns_the_slug(): void
    {
        $slug = 'some-type-of-slug';
        $this->beConstructedThroughFromSlug($slug);

        $this->getKitItemId()->shouldMatchItemSlug($slug);
    }

    public function it_is_json_serializable(): void
    {
        $expected = new ItemSlug('another-slug');

        $this->beConstructedWith($expected);
        $this->shouldHaveType(JsonSerializable::class);

        $this->jsonSerialize()->shouldReturn([
            KitItemQuery::KEY_KIT_ITEM => (string) $expected,
        ]);
    }
}
