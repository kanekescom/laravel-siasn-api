<?php

namespace Kanekescom\Siasn\Api;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Kanekescom\Helperia\Support\ClassExtender;
use Kanekescom\Siasn\Api\Credentials\Token;
use Kanekescom\Siasn\Api\Helpers\Config;

class Siasn extends ClassExtender
{
    public function __construct()
    {
        $this->class = Http::timeout(config('siasn-api.request_timeout'))
            ->retry(config('siasn-api.max_request_attempts'), config('siasn-api.max_request_wait_attempts'), function (Exception $exception, PendingRequest $request) {
                if (! $exception instanceof RequestException || $exception->response->status() !== 401) {
                    return false;
                }

                Token::forget();

                $request
                    ->withToken(Token::getApimToken()->access_token);

                return true;
            })
            ->withOptions([
                'debug' => Config::getDebug(),
                'verify' => Config::getEnableSslVerification(),
            ])
            ->withToken(Token::getApimToken()->access_token);
    }

    public function withSso()
    {
        $ssoToken = Token::getSsoToken();

        return $this->class
            ->retry(config('siasn-api.max_request_attempts'), config('siasn-api.max_request_wait_attempts'), function (Exception $exception, PendingRequest $request) {
                if (! $exception instanceof RequestException || $exception->response->status() !== 401) {
                    return false;
                }

                Token::forget();
                $ssoToken = Token::getSsoToken();

                $request
                    ->withToken(Token::getApimToken()->access_token)
                    ->withHeaders([
                        'Auth' => "{$ssoToken->token_type} {$ssoToken->access_token}",
                    ]);

                return true;
            })
            ->withHeaders([
                'Auth' => "{$ssoToken->token_type} {$ssoToken->access_token}",
            ]);
    }
}
