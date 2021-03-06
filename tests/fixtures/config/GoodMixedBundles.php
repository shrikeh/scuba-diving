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

return [
    Tests\Mock\Bundle\BundleStub::class => ['all' => true, 'bar' => false],
    Tests\Mock\Bundle\AnotherBundleStub::class => ['foo' => true],
    Tests\Mock\Bundle\YetAnotherBundleStub::class => ['bar' => false, 'foo' => true],
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
];
