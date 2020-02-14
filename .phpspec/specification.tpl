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

namespace %namespace%;

use %subject%;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class %name% extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(%subject_class%::class);
    }
}
