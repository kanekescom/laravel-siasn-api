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
}
