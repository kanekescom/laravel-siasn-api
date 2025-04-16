<?php

namespace Kanekes\Siasn\Api\Credentials;

use Exception;
use Illuminate\Support\Facades\Http;
use Kanekes\Siasn\Api\Contracts\CredentialProvider;
use Kanekes\Siasn\Api\Contracts\TokenProvider;
use Kanekes\Siasn\Api\Exceptions\CredentialException;
use Kanekes\Siasn\Api\Exceptions\TokenException;
use Kanekes\Siasn\Api\Services\Config;

class Apim implements TokenProvider
{
    private CredentialProvider $credentialProvider;

    public function __construct(private readonly Config $config, ?CredentialProvider $credentialProvider = null)
    {
        $this->credentialProvider = $credentialProvider ?? new ApimCredentialProvider($config);
    }

    public function getToken(): object
    {
        try {
            $credentials = $this->credentialProvider->getCredentials();
            $this->credentialProvider->validateCredentials($credentials);

            $response = Http::timeout($this->config->getRequestTimeout())
                ->retry($this->config->getMaxRequestAttempts(), $this->config->getMaxRequestWaitAttempts())
                ->withOptions([
                    'debug' => $this->config->isDebugMode(),
                    'verify' => $this->config->isSslVerificationEnabled(),
                ])
                ->withBasicAuth($credentials->username, $credentials->password)
                ->post($credentials->url, [
                    'grant_type' => $credentials->grant_type,
                ]);

            if ($response->failed()) {
                throw new TokenException('Error encountered during APIM token generation: '.PHP_EOL.$response->body());
            }

            $token = $response->object();

            if (blank($token?->access_token)) {
                throw new TokenException('Unable to receive the APIM token correctly');
            }

            return $token;
        } catch (CredentialException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new TokenException('An error occurred while generating the APIM token: '
                .$this->credentialProvider->getCredentials()->username);
        }
    }
}
