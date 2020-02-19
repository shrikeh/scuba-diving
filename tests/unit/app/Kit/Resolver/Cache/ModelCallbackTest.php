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

namespace Tests\Unit\App\Kit\Resolver\Cache;

use App\Kit\Model\ModelInterface;
use App\Kit\Resolver\Cache\ModelCallback;
use App\Kit\Resolver\Exception\ModelNotResolved;
use Closure;
use DateInterval;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use stdClass;
use Symfony\Contracts\Cache\ItemInterface;

final class ModelCallbackTest extends TestCase
{
    public function testItSetsTheExpiry(): void
    {
        $model = $this->prophesize(ModelInterface::class)->reveal();
        $item = $this->prophesize(ItemInterface::class);
        $expiresAfter = new DateInterval('PT2S');
        $item->expiresAfter($expiresAfter)->shouldBeCalledOnce();

        $resolver = Closure::fromCallable(function() use ($model) {
            return $model;
        });

        $callback = new ModelCallback($resolver, $expiresAfter);

        $this->assertSame($model, $callback($item->reveal()));
    }

    public function testItAssertsItReturnsAModel(): void
    {
        $notAModel = new stdClass();
        $item = $this->prophesize(ItemInterface::class);
        $expiresAfter = new DateInterval('PT2S');
        $item->expiresAfter(Argument::any())->shouldNotBeCalled();

        $resolver = Closure::fromCallable(function() use ($notAModel) {
            return $notAModel;
        });

        $callback = ModelCallback::asClosure($resolver, $expiresAfter);

        $this->expectExceptionObject(ModelNotResolved::fromResolved($notAModel, ModelInterface::class));

        $callback($item->reveal());
    }
}
