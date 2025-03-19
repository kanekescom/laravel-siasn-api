<?php

namespace Kanekes\Siasn\Api\Credentials;

use Exception;
use Illuminate\Support\Facades\Http;
use Kanekes\Siasn\Api\Contracts\CredentialProvider;
use Kanekes\Siasn\Api\Contracts\TokenProvider;
use Kanekes\Siasn\Api\Exceptions\CredentialException;
use Kanekes\Siasn\Api\Exceptions\TokenException;
use Kanekes\Siasn\Api\Services\Config;

class Sso implements TokenProvider
{
    private CredentialProvider $credentialProvider;

    public function __construct(private readonly Config $config, ?CredentialProvider $credentialProvider = null)
    {
        $this->credentialProvider = $credentialProvider ?? new SsoCredentialProvider($config);
    }

    public function getToken(): object
    {
        try {
            $credentials = $this->credentialProvider->getCredentials();
            $this->credentialProvider->validateCredentials($credentials);

            if ($credentials->generate) {
                $response = Http::timeout($this->config->getRequestTimeout())
                    ->asForm()
                    ->retry($this->config->getMaxRequestAttempts(), $this->config->getMaxRequestWaitAttempts())
                    ->withOptions([
                        'debug' => $this->config->isDebugMode(),
                        'verify' => $this->config->isSslVerificationEnabled(),
                    ])
                    ->post($credentials->url, [
                        'grant_type' => $credentials->grant_type,
                        'client_id' => $credentials->client_id,
                        'username' => $credentials->username,
                        'password' => $credentials->password,
                        'token_type' => $credentials->token_type,
                        'access_token' => $credentials->access_token,
                    ]);

                if ($response->failed()) {
                    throw new TokenException('Error encountered during SSO token generation: '.PHP_EOL.$response->body());
                }

                $token = $response->object();
            } else {
                $token = (object) [
                    'grant_type' => $credentials->grant_type,
                    'client_id' => $credentials->client_id,
                    'username' => $credentials->username,
                    'password' => $credentials->password,
                    'token_type' => $credentials->token_type,
                    'access_token' => $credentials->access_token,
                ];
            }

            if (blank($token?->access_token)) {
                throw new TokenException('Unable to receive the SSO token correctly');
            }

            return $token;
        } catch (CredentialException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new TokenException('An error occurred while generating the SSO token: '.PHP_EOL.$e->getMessage());
        }
    }
}
