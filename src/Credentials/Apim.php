<?php

namespace Kanekescom\Siasn\Api\Credentials;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Kanekescom\Siasn\Api\Contracts\Tokenize;
use Kanekescom\Siasn\Api\Exceptions\InvalidApimCredentialsException;
use Kanekescom\Siasn\Api\Helpers\Config;

class Apim implements Tokenize
{
    public static function getToken(): Response
    {
        $credential = Config::getApimCredential();

        if (blank($credential->username)) {
            throw new InvalidApimCredentialsException('username must be set');
        }

        if (blank($credential->password)) {
            throw new InvalidApimCredentialsException('password must be set');
        }

        return Http::withOptions([
            'debug' => Config::getDebug(),
        ])->withBasicAuth(
            $credential->username,
            $credential->password
        )->post($credential->url, [
            'grant_type' => $credential->grant_type,
        ]);
    }
}
