<?php

namespace Kanekes\Siasn\Api\Http;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Kanekes\Siasn\Api\Contracts\TokenManager;

class RequestRetryHandler
{
    public function __construct(private readonly TokenManager $tokenManager) {}

    public function handleApimRetry(Exception $exception, PendingRequest $request): bool
    {
        if (! ($exception instanceof RequestException) || $exception->response->status() !== 401) {
            return false;
        }

        $this->tokenManager->forgetTokens();
        $apimToken = $this->tokenManager->getApimToken();
        $request->withToken($apimToken->access_token);

        return true;
    }

    public function handleSsoRetry(Exception $exception, PendingRequest $request): bool
    {
        if (! ($exception instanceof RequestException) || $exception->response->status() !== 401) {
            return false;
        }

        $this->tokenManager->forgetTokens();

        $apimToken = $this->tokenManager->getApimToken();
        $ssoToken = $this->tokenManager->getSsoToken();

        $request
            ->withToken($apimToken->access_token)
            ->withHeaders([
                'Auth' => $ssoToken->token_type.' '.$ssoToken->access_token,
            ]);

        return true;
    }
}
