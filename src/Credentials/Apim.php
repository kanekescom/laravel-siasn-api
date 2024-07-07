<?php

namespace Kanekescom\Siasn\Api\Credentials;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Kanekescom\Siasn\Api\Contracts\Tokenize;
use Kanekescom\Siasn\Api\Exceptions\InvalidApimCredentialsException;
use Kanekescom\Siasn\Api\Exceptions\InvalidTokenException;
use Kanekescom\Siasn\Api\Helpers\Config;

class Apim implements Tokenize
{
    /**
     * @throws InvalidApimCredentialsException|ConnectionException
     */
    public static function getToken(): object
    {
        $credential = Config::getApimCredential();

        if (blank($credential->username)) {
            throw new InvalidApimCredentialsException('username must be set');
        }

        if (blank($credential->password)) {
            throw new InvalidApimCredentialsException('password must be set');
        }

        $response = Http::timeout(config('siasn-api.request_timeout'))
            ->retry(config('siasn-api.max_request_attempts'), config('siasn-api.max_request_wait_attempts'))
            ->withOptions([
                'debug' => Config::getDebug(),
                'verify' => Config::getEnableSslVerification(),
            ])->withBasicAuth(
                $credential->username,
                $credential->password
            )->post($credential->url, [
                'grant_type' => $credential->grant_type,
            ]);

        $token = $response->object();

        if (blank(optional($token)->access_token)) {
            throw new InvalidTokenException('Not receiving tokens correctly.');
        }

        return $token;
    }
}
