<?php

declare(strict_types=1);

namespace spec\Shrikeh\Diving\Kit;

use Shrikeh\Diving\Kit\Manufacturer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class ManufacturerSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Manufacturer::class);
    }
}
