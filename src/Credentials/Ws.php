<?php

namespace Kanekescom\Siasn\Api\Credentials;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Kanekescom\Siasn\Api\Contracts\Tokenize;
use Kanekescom\Siasn\Api\Exceptions\InvalidWsCredentialsException;
use Kanekescom\Siasn\Api\SiasnConfig;

class Ws implements Tokenize
{
    /**
     * Get token from WS.
     */
    public static function getToken(): Response
    {
        $credential = SiasnConfig::getWsCredential();

        if (blank($credential->username)) {
            throw new InvalidWsCredentialsException('username must be set');
        }

        if (blank($credential->password)) {
            throw new InvalidWsCredentialsException('password must be set');
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
