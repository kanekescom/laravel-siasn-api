<?php

namespace Kanekes\Siasn\Api\Credentials;

use Kanekes\Siasn\Api\Contracts\CredentialProvider;
use Kanekes\Siasn\Api\Exceptions\CredentialException;
use Kanekes\Siasn\Api\Services\Config;

class SsoCredentialProvider implements CredentialProvider
{
    public function __construct(private readonly Config $config) {}

    public function getCredentials(): object
    {
        return $this->config->getSsoCredential();
    }

    public function validateCredentials(object $credentials): bool
    {
        $requiredFields = [
            'client_id' => 'SSO client_id must be set',
            'username' => 'SSO username must be set',
            'password' => 'SSO password must be set',
        ];

        foreach ($requiredFields as $field => $error) {
            if (blank($credentials->$field)) {
                throw new CredentialException($error);
            }
        }

        if ($credentials->generate) {
            $additionalFields = [
                'token_type' => 'SSO token_type must be set',
                'access_token' => 'SSO access_token must be set',
            ];

            foreach ($additionalFields as $field => $error) {
                if (blank($credentials->$field)) {
                    throw new CredentialException($error);
                }
            }
        }

        return true;
    }
}
