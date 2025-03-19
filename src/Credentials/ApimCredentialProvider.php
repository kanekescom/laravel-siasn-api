<?php

namespace Kanekes\Siasn\Api\Credentials;

use Kanekes\Siasn\Api\Contracts\CredentialProvider;
use Kanekes\Siasn\Api\Exceptions\CredentialException;
use Kanekes\Siasn\Api\Services\Config;

class ApimCredentialProvider implements CredentialProvider
{
    public function __construct(private readonly Config $config) {}

    public function getCredentials(): object
    {
        return $this->config->getApimCredential();
    }

    public function validateCredentials(object $credentials): bool
    {
        $requiredFields = [
            'username' => 'APIM username must be set',
            'password' => 'APIM password must be set',
        ];

        foreach ($requiredFields as $field => $error) {
            if (blank($credentials->$field)) {
                throw new CredentialException($error);
            }
        }

        return true;
    }
}
