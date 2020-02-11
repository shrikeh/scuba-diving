<?php

declare(strict_types=1);

namespace Tests\Unit\App\Api\ResponseResolver;

use App\Api\ResponseParserInterface;
use App\Api\ResponseResolver\ResponseResolver;
use App\Kit\Model\ModelInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ResponseResolverTest extends TestCase
{
    public function testiItParsesAResponse(): void
    {
        /** @var ResponseInterface $response */
        $response = $this->prophesize(ResponseInterface::class)->reveal();

        /** @var ModelInterface $model */
        $model = $this->prophesize(ModelInterface::class)->reveal();
        $parser = $this->prophesize(ResponseParserInterface::class);

        $parser->parse($response)->willReturn($model);

        $resolver = new ResponseResolver(
            $response,
            $parser->reveal()
        );

        $this->assertSame($model, $resolver());
    }
}
