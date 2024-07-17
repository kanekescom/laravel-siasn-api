<?php

namespace Kanekescom\Siasn\Api\Credentials;

use Exception;
use Illuminate\Support\Facades\Http;
use Kanekescom\Siasn\Api\Contracts\Tokenize;
use Kanekescom\Siasn\Api\Exceptions\InvalidSsoCredentialsException;
use Kanekescom\Siasn\Api\Exceptions\InvalidTokenException;
use Kanekescom\Siasn\Api\Helpers\Config;

class Sso implements Tokenize
{
    /**
     * @throws InvalidSsoCredentialsException
     * @throws InvalidTokenException
     */
    public static function getToken(): object
    {
        $credential = Config::getSsoCredential();

        if (blank($credential->client_id)) {
            throw new InvalidSsoCredentialsException('SSO client_id must be set');
        }

        if (blank($credential->username)) {
            throw new InvalidSsoCredentialsException('SSO username must be set');
        }

        if (blank($credential->password)) {
            throw new InvalidSsoCredentialsException('SSO password must be set');
        }

        try {
            $response = Http::timeout(config('siasn-api.request_timeout'))
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

            if ($response->failed()) {
                throw new InvalidTokenException('Error encountered during SSO token generation: '.PHP_EOL.$response->body());
            }

            $token = $response->object();

            if (blank($token?->access_token)) {
                throw new InvalidTokenException('Unable to receive the SSO token correctly');
            }

            return $token;
        } catch (Exception $e) {
            throw new InvalidTokenException('An error occurred while generating the SSO token: '.PHP_EOL.$e->getMessage());
        }
    }
}
