<?php

namespace Kanekescom\Siasn\Api;

use Illuminate\Support\Facades\Http;
use Kanekescom\Helperia\Support\ClassExtender;
use Kanekescom\Siasn\Api\Credentials\Token;
use Kanekescom\Siasn\Api\Helpers\Config;

class Siasn extends ClassExtender
{
    /**
     * Create a new instance.
     */
    public function __construct()
    {
        $apimToken = Token::getApimToken();
        $ssoToken = Token::getSsoToken();

        $this->class = Http::retry(3, 100)
            ->withOptions([
                'debug' => Config::getDebug(),
            ])->withHeaders([
                'Auth' => "{$ssoToken->token_type} {$ssoToken->access_token}",
            ])->withToken(
                $apimToken->access_token
            );
    }
}
