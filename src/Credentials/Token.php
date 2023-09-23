<?php

namespace Kanekescom\Siasn\Api\Credentials;

use Kanekescom\Siasn\Api\Exceptions\InvalidApimCredentialsException;
use Kanekescom\Siasn\Api\Exceptions\InvalidSsoCredentialsException;
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
     * Get Apim token.
     */
    public static function getApimToken()
    {
        return cache()->remember('apim-token', SiasnConfig::getApimTokenAge(), function () {
            $apimToken = Apim::getToken()->object();

            if (blank(optional($apimToken)->access_token)) {
                throw new InvalidApimCredentialsException('Invalid Apim user credentials.');
            }

            return $apimToken;
        });
    }
}
