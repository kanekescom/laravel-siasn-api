<?php

namespace Kanekes\Siasn\Api\Contracts;

interface CredentialProvider
{
    /**
     * Get credentials required for authentication.
     *
     * @throws \Kanekes\Siasn\Api\Exceptions\CredentialException
     */
    public function getCredentials(): object;

    /**
     * Validate credentials.
     *
     * @throws \Kanekes\Siasn\Api\Exceptions\CredentialException
     */
    public function validateCredentials(object $credentials): bool;
}
