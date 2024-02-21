<?php

namespace Kanekescom\Siasn\Api;

use Illuminate\Support\Facades\Http;
use Kanekescom\Helperia\Support\ClassExtender;
use Kanekescom\Siasn\Api\Credentials\Token;
use Kanekescom\Siasn\Api\Helpers\Config;

class Siasn extends ClassExtender
{
    public function __construct()
    {
        $apimToken = Token::getApimToken();

        $this->class = Http::retry(3, 100)
            ->timeout(config('siasn-api.timeout'))
            ->withOptions([
                'debug' => Config::getDebug(),
                'verify' => false,
            ])->withToken(
                $apimToken->access_token
            );
    }

    public function withSso()
    {
        $ssoToken = Token::getSsoToken();

        return $this->class->withHeaders([
            'Auth' => "{$ssoToken->token_type} {$ssoToken->access_token}",
        ]);
    }
}
