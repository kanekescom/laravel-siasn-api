<?php

namespace Kanekescom\Siasn\Api\Credentials;

use Kanekescom\Siasn\Api\SiasnConfig;

class Token
{
    /**
     * Get SSO token.
     */
    public static function getSsoToken()
    {
        return cache()->remember('sso-token', SiasnConfig::getSsoTokenAge(), function () {
            return Sso::getToken()->object();
        });
    }

    /**
     * Get WS token.
     */
    public static function getWsToken()
    {
        return cache()->remember('ws-token', SiasnConfig::getWsTokenAge(), function () {
            return Ws::getToken()->object();
        });
    }
}
