<?php

namespace Kanekescom\Siasn\Api\Credentials;

use Exception;
use Illuminate\Support\Facades\Http;
use Kanekescom\Siasn\Api\Contracts\Tokenize;
use Kanekescom\Siasn\Api\Exceptions\InvalidApimCredentialsException;
use Kanekescom\Siasn\Api\Exceptions\InvalidTokenException;
use Kanekescom\Siasn\Api\Helpers\Config;

class Apim implements Tokenize
{
    /**
     * @throws InvalidApimCredentialsException
     * @throws InvalidTokenException
     */
    public static function getToken(): object
    {
        $credential = Config::getApimCredential();

        if (blank($credential->username)) {
            throw new InvalidApimCredentialsException('APIM username must be set');
        }

        if (blank($credential->password)) {
            throw new InvalidApimCredentialsException('APIM password must be set');
        }

        try {
            $response = Http::timeout(config('siasn-api.request_timeout'))
                ->retry(config('siasn-api.max_request_attempts'), config('siasn-api.max_request_wait_attempts'))
                ->withOptions([
                    'debug' => Config::getDebug(),
                    'verify' => Config::getEnableSslVerification(),
                ])
                ->withBasicAuth($credential->username, $credential->password)
                ->post($credential->url, [
                    'grant_type' => $credential->grant_type,
                ]);

            if ($response->failed()) {
                throw new InvalidTokenException('Error encountered during APIM token generation: '.PHP_EOL.$response->body());
            }

            $token = $response->object();

            if (blank($token?->access_token)) {
                throw new InvalidTokenException('Unable to receive the APIM token correctly');
            }

            return $token;
        } catch (Exception $e) {
            throw new InvalidTokenException('An error occurred while generating the APIM token: '.PHP_EOL.$e->getMessage());
        }
    }
}
