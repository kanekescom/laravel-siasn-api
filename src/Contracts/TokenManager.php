<?php

namespace Kanekes\Siasn\Api\Contracts;

interface TokenManager
{
    /**
     * Get a token from the specified provider.
     */
    public function getToken(string $provider): object;

    /**
     * Get a fresh token from the specified provider.
     */
    public function getFreshToken(string $provider): object;

    /**
     * Forget all cached tokens.
     */
    public function forgetTokens(): void;

    /**
     * Shortcut for getToken('apim')
     */
    public function getApimToken(): object;

    /**
     * Shortcut for getToken('sso')
     */
    public function getSsoToken(): object;

    /**
     * Shortcut for getFreshToken('apim')
     */
    public function getNewApimToken(): object;

    /**
     * Shortcut for getFreshToken('sso')
     */
    public function getNewSsoToken(): object;
}
