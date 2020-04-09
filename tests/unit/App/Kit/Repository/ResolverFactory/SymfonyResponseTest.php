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

namespace Tests\Unit\App\Kit\Repository\ResolverFactory;

use App\Api\ResponseParser\ResponseParserInterface;
use App\Kit\Model\ModelInterface;
use App\Kit\Repository\ResolverFactory\SymfonyResponse;
use PHPUnit\Framework\TestCase;
use Shrikeh\Diving\Kit\Item\ItemSlug;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class SymfonyResponseTest extends TestCase
{
    public function testItCreatesAResolver(): void
    {
        $model = $this->prophesize(ModelInterface::class)->reveal();
        $responseParser = $this->prophesize(ResponseParserInterface::class);
        $response = $this->prophesize(ResponseInterface::class)->reveal();

        $responseParser->parse($response)->willReturn($model);

        $symfonyResolverFactory = new SymfonyResponse($responseParser->reveal());

        $itemSlug = new ItemSlug('foo');

        $resolver = $symfonyResolverFactory->createResolver($response, $itemSlug->toUuid());

        $this->assertSame($model, $resolver());
    }
}
