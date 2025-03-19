<?php

namespace Kanekes\Siasn\Api\Http;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Kanekes\Siasn\Api\Contracts\TokenManager;
use Kanekes\Siasn\Api\Services\Config;

class Client
{
    private Config $config;

    private TokenManager $tokenManager;

    private RequestRetryHandler $retryHandler;

    private PendingRequest $httpClient;

    public function __construct(Config $config, TokenManager $tokenManager, ?RequestRetryHandler $retryHandler = null)
    {
        $this->config = $config;
        $this->tokenManager = $tokenManager;
        $this->retryHandler = $retryHandler ?? new RequestRetryHandler($tokenManager);
        $this->initializeHttpClient();
    }

    private function initializeHttpClient(): void
    {
        $apimToken = $this->tokenManager->getApimToken();

        $this->httpClient = Http::timeout($this->config->getRequestTimeout())
            ->retry(
                $this->config->getMaxRequestAttempts(),
                $this->config->getMaxRequestWaitAttempts(),
                function (Exception $exception, PendingRequest $request) {
                    return $this->retryHandler->handleApimRetry($exception, $request);
                }
            )
            ->withOptions([
                'debug' => $this->config->isDebugMode(),
                'verify' => $this->config->isSslVerificationEnabled(),
            ])
            ->withToken($apimToken->access_token);
    }

    public function getHttpClient(): PendingRequest
    {
        return $this->httpClient;
    }

    public function withSso(): PendingRequest
    {
        $ssoToken = $this->tokenManager->getSsoToken();

        return $this->httpClient
            ->retry(
                $this->config->getMaxRequestAttempts(),
                $this->config->getMaxRequestWaitAttempts(),
                function (Exception $exception, PendingRequest $request) {
                    return $this->retryHandler->handleSsoRetry($exception, $request);
                }
            )
            ->withHeaders([
                'Auth' => $ssoToken->token_type.' '.$ssoToken->access_token,
            ]);
    }
}
