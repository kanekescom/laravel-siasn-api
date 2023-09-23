<?php

namespace Kanekescom\Siasn\Api\Credentials;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Kanekescom\Siasn\Api\Contracts\Tokenize;
use Kanekescom\Siasn\Api\Exceptions\InvalidApimCredentialsException;
use Kanekescom\Siasn\Api\SiasnConfig;

class Apim implements Tokenize
{
    /**
     * Get token from Apim.
     */
    public static function getToken(): Response
    {
        $credential = SiasnConfig::getApimCredential();

        if (blank($credential->username)) {
            throw new InvalidApimCredentialsException('username must be set');
        }

        if (blank($credential->password)) {
            throw new InvalidApimCredentialsException('password must be set');
        }

        return Http::withOptions([
            'debug' => SiasnConfig::getDebug(),
        ])->withBasicAuth(
            $credential->username,
            $credential->password
        )->post($credential->url, [
            'grant_type' => $credential->grant_type,
        ]);
    }
}
