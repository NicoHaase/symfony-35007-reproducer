<?php

namespace App\Tests;

use App\ApiClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class ApiClientTest extends TestCase
{
    public function testNo404IsThrownOnExistingUrl(): void
    {
        $callback = function ($method, $url, $options) {
            return new MockResponse('[]');
        };

        $mockedClient = new MockHttpClient($callback);

        $client = new ApiClient($mockedClient);

        $this->assertFalse($client->yields404('http://this.exists'));
    }

    public function test404IsThrownOnNonexistingUrl(): void
    {
        $callback = function ($method, $url, $options) {
            return new MockResponse('[]', ['http_code' => 404]);
        };

        $mockedClient = new MockHttpClient($callback);

        $client = new ApiClient($mockedClient);

        $this->assertTrue($client->yields404('http://this.is.nonexisting'));
    }
}
