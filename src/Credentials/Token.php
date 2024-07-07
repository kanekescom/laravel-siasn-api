<?php

namespace Kanekescom\Siasn\Api\Credentials;

use Kanekescom\Siasn\Api\Exceptions\InvalidApimCredentialsException;
use Kanekescom\Siasn\Api\Exceptions\InvalidSsoCredentialsException;
use Kanekescom\Siasn\Api\Helpers\Config;

class Token
{
    public static function getSsoToken()
    {
        return cache()->remember('sso-token', Config::getSsoTokenAge(), function () {
            $ssoToken = Sso::getToken()->object();

            if (blank(optional($ssoToken)->token_type) || blank(optional($ssoToken)->access_token)) {
                throw new InvalidSsoCredentialsException('Invalid SSO user credentials.');
            }

            return $ssoToken;
        });
    }

    public static function getApimToken()
    {
        return cache()->remember('apim-token', Config::getApimTokenAge(), function () {
            $apimToken = Apim::getToken()->object();

            if (blank(optional($apimToken)->access_token)) {
                throw new InvalidApimCredentialsException('Invalid Apim user credentials.');
            }

            return $apimToken;
        });
    }

    public static function forget(): void
    {
        cache()->forget('apim-token');
        cache()->forget('sso-token');
    }
}
