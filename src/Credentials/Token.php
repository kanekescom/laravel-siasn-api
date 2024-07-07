<?php

namespace Kanekescom\Siasn\Api\Credentials;

use Kanekescom\Siasn\Api\Helpers\Config;

class Token
{
    public static function getApimToken(): object
    {
        return cache()->remember('apim-token', Config::getApimTokenAge(), function () {
            return Apim::getToken();
        });
    }

    public static function getSsoToken(): object
    {
        return cache()->remember('sso-token', Config::getSsoTokenAge(), function () {
            return Sso::getToken();
        });
    }

    public static function getNewApimToken(): object
    {
        cache()->forget('apim-token');

        return self::getApimToken();
    }

    public static function getNewSsoToken(): object
    {
        cache()->forget('sso-token');

        return self::getSsoToken();
    }

    public static function forget(): void
    {
        cache()->forget('apim-token');
        cache()->forget('sso-token');
    }
}
