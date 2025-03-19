<?php

namespace Kanekes\Siasn\Api\Contracts;

interface TokenProvider
{
    /**
     * Get an authentication token.
     *
     * @throws \Kanekes\Siasn\Api\Exceptions\TokenException
     */
    public function getToken(): object;
}
