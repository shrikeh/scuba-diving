<?php

namespace Tests\Unit\App\Kit\Repository\Manufacturer\ResponseParser\Exception;

use App\Kit\Repository\Manufacturer\ResponseParser\Exception\ApiResponse;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\JsonException;

class ApiResponseTest extends TestCase
{
    public function testItWrapsAExceptionInterface(): void
    {
        $code = 231;
        $exception = new JsonException('Problem', $code);
        $apiException = ApiResponse::wrap($exception);

        $this->assertSame($code, $apiException->getCode());
    }

    public function testItGivesADefaultCodeIfTheExceptionHasNoCode(): void
    {
        $exception = new JsonException('Another problem');
        $apiException = ApiResponse::wrap($exception);

        $this->assertSame(ApiResponse::DEFAULT_CODE, $apiException->getCode());
    }
}
