<?php

namespace Kanekescom\Siasn\Api\Credentials;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Kanekescom\Siasn\Api\Contracts\Tokenize;
use Kanekescom\Siasn\Api\Exceptions\InvalidSsoCredentialsException;
use Kanekescom\Siasn\Api\Helpers\Config;

class Sso implements Tokenize
{
    /**
     * @throws InvalidSsoCredentialsException|ConnectionException
     */
    public static function getToken(): Response
    {
        $credential = Config::getSsoCredential();

        if (blank($credential->client_id)) {
            throw new InvalidSsoCredentialsException('client_id must be set');
        }

        if (blank($credential->username)) {
            throw new InvalidSsoCredentialsException('username must be set');
        }

        if (blank($credential->password)) {
            throw new InvalidSsoCredentialsException('password must be set');
        }

        return Http::timeout(config('siasn-api.request_timeout'))
            ->asForm()
            ->retry(config('siasn-api.max_request_attempts'), config('siasn-api.max_request_wait_attempts'))
            ->withOptions([
                'debug' => Config::getDebug(),
                'verify' => Config::getEnableSslVerification(),
            ])
            ->post($credential->url, [
                'grant_type' => $credential->grant_type,
                'client_id' => $credential->client_id,
                'username' => $credential->username,
                'password' => $credential->password,
            ]);
    }
}
