<?php

declare(strict_types=1);

namespace spec\Shrikeh\Diving\Kit;

use Psr\Http\Message\UriInterface;
use Shrikeh\Diving\Kit\Manufacturer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class ManufacturerSpec extends ObjectBehavior
{
    public function it_returns_the_name(): void
    {
        $name = "O'Three";

        $this->beConstructedWith($name);

        $this->getName()->shouldReturn($name);
        $this->getLogo()->shouldReturn(null);
        $this->getWebsite()->shouldReturn(null);
    }

    public function it_returns_the_website_if_there_is_one(
        UriInterface $logo,
        UriInterface $website
    ): void {
        $name = 'Scubapro';

        $this->beConstructedWith($name, $logo, $website);

        $this->getWebsite()->shouldReturn($website);
    }

    public function it_returns_the_logo_if_there_is_one(
        UriInterface $logo,
        UriInterface $website
    ): void {
        $name = 'Northern Diver';
        $this->beConstructedWith($name, $logo, $website);

        $this->getLogo()->shouldReturn($logo);
    }
}
