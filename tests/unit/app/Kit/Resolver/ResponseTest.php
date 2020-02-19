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

namespace Tests\Unit\App\Kit\Resolver;

use App\Api\ResponseParserInterface;
use App\Kit\Model\ModelInterface;
use App\Kit\Resolver\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ResponseTest extends TestCase
{
    public function testiItParsesAResponse(): void
    {
        /** @var ResponseInterface $response */
        $response = $this->prophesize(ResponseInterface::class)->reveal();

        /** @var ModelInterface $model */
        $model = $this->prophesize(ModelInterface::class)->reveal();
        $parser = $this->prophesize(ResponseParserInterface::class);

        $parser->parse($response)->willReturn($model);

        $resolver = new Response(
            $response,
            $parser->reveal()
        );

        $this->assertSame($model, $resolver());
    }
}
