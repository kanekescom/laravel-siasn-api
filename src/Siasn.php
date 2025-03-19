<?php

namespace Kanekes\Siasn\Api;

use Illuminate\Http\Client\PendingRequest;
use Kanekes\Siasn\Api\Credentials\Token;
use Kanekes\Siasn\Api\Http\Client;
use Kanekes\Siasn\Api\Services\Config;

class Siasn
{
    private Client $httpClient;

    public function __construct(?Client $httpClient = null)
    {
        $config = new Config;
        $tokenManager = new Token($config);
        $this->httpClient = $httpClient ?? new Client($config, $tokenManager);
    }

    public function withSso(): PendingRequest
    {
        return $this->httpClient->withSso();
    }

    public function __call($method, $parameters)
    {
        return $this->httpClient->getHttpClient()->$method(...$parameters);
    }
}
