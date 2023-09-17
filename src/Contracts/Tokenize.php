<?php

namespace Kanekescom\Siasn\Api\Contracts;

use Illuminate\Http\Client\Response;

interface Tokenize
{
    /**
     * Get token.
     */
    public static function getToken(): Response;
}
