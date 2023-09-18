<?php

namespace Kanekescom\Siasn\Api\Credentials;

use Kanekescom\Siasn\Api\Exceptions\InvalidSsoCredentialsException;
use Kanekescom\Siasn\Api\Exceptions\InvalidWsCredentialsException;
use Kanekescom\Siasn\Api\SiasnConfig;

class Token
{
    /**
     * Get SSO token.
     */
    public static function getSsoToken()
    {
        return cache()->remember('sso-token', SiasnConfig::getSsoTokenAge(), function () {
            $ssoToken = Sso::getToken()->object();

            if (blank(optional($ssoToken)->token_type) || blank(optional($ssoToken)->access_token)) {
                throw new InvalidSsoCredentialsException('Invalid SSO user credentials.');
            }

            return $ssoToken;
        });
    }

    /**
     * Get WS token.
     */
    public static function getWsToken()
    {
        return cache()->remember('ws-token', SiasnConfig::getWsTokenAge(), function () {
            $wsToken = Ws::getToken()->object();

            if (blank(optional($wsToken)->access_token)) {
                throw new InvalidWsCredentialsException('Invalid WS user credentials.');
            }

            return $wsToken;
        });
    }
}
