<?php

declare(strict_types=1);

namespace spec\Shrikeh\Diving\Kit;

use Shrikeh\Diving\Kit\Item;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class ItemSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Item::class);
    }
}
