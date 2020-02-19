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

namespace spec\Shrikeh\Diving\Kit;

use PhpSpec\ObjectBehavior;
use Psr\Http\Message\UriInterface;

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
