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

namespace spec\Shrikeh\Diving\Kit\Item;

use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shrikeh\Diving\Kit\Item\ItemSlug;

final class ItemSlugSpec extends ObjectBehavior
{
    public function getMatchers(): array
    {
        return [
            'beAValidUuid' => function(UuidInterface $actual, string $slug): bool
            {
                $expected = Uuid::uuid5(ItemSlug::OID_ITEM_NAMESPACE, $slug);

                return $expected->equals($actual);
            }
        ];
    }

    public function it_returns_the_slug(): void
    {
        $slug = 'a-diving-knife';

        $this->beConstructedWith($slug);
        $this->toSlug()->shouldReturn($slug);
    }

    public function it_returns_the_uuid(): void
    {
        $slug = 'scubaro-fins';

        $this->beConstructedWith($slug);

        $this->toUuid()->shouldBeAValidUuid($slug);
    }

    public function it_behaves_as_a_uuid_when_used_as_string(): void
    {
        $slug = 'ap-diving-buddy-commando';
        $expected = Uuid::uuid5(ItemSlug::OID_ITEM_NAMESPACE, $slug);

        $this->beConstructedWith($slug);

        $this->__toString()->shouldReturn($expected->toString());
    }
}
