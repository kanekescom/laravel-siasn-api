<?php

namespace Kanekescom\Siasn\Api;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Kanekescom\Helperia\Support\ClassExtender;
use Kanekescom\Siasn\Api\Credentials\Token;
use Kanekescom\Siasn\Api\Exceptions\InvalidApimCredentialsException;
use Kanekescom\Siasn\Api\Exceptions\InvalidSsoCredentialsException;
use Kanekescom\Siasn\Api\Exceptions\InvalidTokenException;
use Kanekescom\Siasn\Api\Helpers\Config;

class Siasn extends ClassExtender
{
    /**
     * @throws InvalidApimCredentialsException
     * @throws InvalidTokenException
     */
    public function __construct()
    {
        $this->initializeHttpClass();
    }

    /**
     * @throws InvalidApimCredentialsException
     * @throws InvalidTokenException
     */
    private function initializeHttpClass(): void
    {
        $apimToken = Token::getApimToken();

        $this->class = Http::timeout(config('siasn-api.request_timeout'))
            ->retry(
                config('siasn-api.max_request_attempts'),
                config('siasn-api.max_request_wait_attempts'),
                function (Exception $exception, PendingRequest $request) {
                    return $this->handleRetry($exception, $request);
                }
            )
            ->withOptions([
                'debug' => Config::getDebug(),
                'verify' => Config::getEnableSslVerification(),
            ])
            ->withToken($apimToken->access_token);
    }

    /**
     * @throws InvalidApimCredentialsException
     * @throws InvalidTokenException
     */
    private function handleRetry(Exception $exception, PendingRequest $request): bool
    {
        if (! ($exception instanceof RequestException) || $exception->response->status() !== 401) {
            return false;
        }

        Token::forget();
        $apimToken = Token::getApimToken();
        $request->withToken($apimToken->access_token);

        return true;
    }

    /**
     * @noinspection PhpUnused
     *
     * @throws InvalidTokenException
     * @throws InvalidSsoCredentialsException
     * @throws InvalidApimCredentialsException
     */
    public function withSso(): PendingRequest
    {
        $ssoToken = Token::getSsoToken();

        return $this->class
            ->retry(
                config('siasn-api.max_request_attempts'),
                config('siasn-api.max_request_wait_attempts'),
                function (Exception $exception, PendingRequest $request) {
                    return $this->handleSsoRetry($exception, $request);
                }
            )
            ->withHeaders([
                'Auth' => $ssoToken->token_type.' '.$ssoToken->access_token,
            ]);
    }

    /**
     * Handle retry logic for failed SSO requests.
     *
     * @throws InvalidApimCredentialsException
     * @throws InvalidSsoCredentialsException
     * @throws InvalidTokenException
     */
    private function handleSsoRetry(Exception $exception, PendingRequest $request): bool
    {
        if (! ($exception instanceof RequestException) || $exception->response->status() !== 401) {
            return false;
        }

        Token::forget();

        $apimToken = Token::getApimToken();
        $newSsoToken = Token::getSsoToken();

        $request
            ->withToken($apimToken->access_token)
            ->withHeaders([
                'Auth' => $newSsoToken->token_type.' '.$newSsoToken->access_token,
            ]);

        return true;
    }
}
