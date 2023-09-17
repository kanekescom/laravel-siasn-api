<?php

namespace Kanekescom\Siasn\Api\Credentials;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Kanekescom\Siasn\Api\Contracts\Tokenize;
use Kanekescom\Siasn\Api\Exceptions\InvalidSsoCredentialsException;
use Kanekescom\Siasn\Api\SiasnConfig;

class Sso implements Tokenize
{
    /**
     * Get token from SSO.
     */
    public static function getToken(): Response
    {
        $credential = SiasnConfig::getSsoCredential();

        if (blank($credential->client_id)) {
            throw new InvalidSsoCredentialsException('client_id must be set');
        }

        if (blank($credential->username)) {
            throw new InvalidSsoCredentialsException('username must be set');
        }

        if (blank($credential->password)) {
            throw new InvalidSsoCredentialsException('password must be set');
        }

        return Http::asForm()->withOptions([
            'debug' => SiasnConfig::getDebug(),
        ])->post($credential->url, [
            'grant_type' => $credential->grant_type,
            'client_id' => $credential->client_id,
            'username' => $credential->username,
            'password' => $credential->password,
        ]);
    }
}
