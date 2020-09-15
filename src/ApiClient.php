<?php

namespace App;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClient
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function yields404(string $url): bool
    {
        $response = $this->client->request('GET', $url);
        return $response->getStatusCode() === 404;
    }
}