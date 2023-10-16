<?php

namespace Kanekescom\Siasn\Api\Contracts;

use Illuminate\Http\Client\Response;

interface Tokenize
{
    public static function getToken(): Response;
}
