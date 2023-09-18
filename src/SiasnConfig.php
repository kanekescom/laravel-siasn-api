<?php

namespace Kanekescom\Siasn\Api;

class SiasnConfig
{
    /**
     * Get mode.
     */
    public static function getMode(): string
    {
        return config('siasn.mode');
    }

    /**
     * Get is production.
     */
    public static function isProduction(): bool
    {
        return self::getMode() === 'production';
    }

    /**
     * Get is training.
     */
    public static function isTraining(): bool
    {
        return self::getMode() === 'training';
    }

    /**
     * Get mode.
     */
    public static function getDebug(): bool
    {
        return config('siasn.debug');
    }

    /**
     * Get WS configuration.
     */
    public static function getWsCredential(): object
    {
        return (object) [
            'url' => config('siasn.ws.'.self::getMode().'.url'),
            'username' => config('siasn.ws.'.self::getMode().'.username'),
            'password' => config('siasn.ws.'.self::getMode().'.password'),
            'grant_type' => config('siasn.ws.'.self::getMode().'.grant_type'),
        ];
    }

    /**
     * Get SSO configuration.
     */
    public static function getSsoCredential(): object
    {
        return (object) [
            'url' => config('siasn.sso.'.self::getMode().'.url'),
            'client_id' => config('siasn.sso.'.self::getMode().'.client_id'),
            'username' => config('siasn.sso.'.self::getMode().'.username'),
            'password' => config('siasn.sso.'.self::getMode().'.password'),
            'grant_type' => config('siasn.sso.'.self::getMode().'.grant_type'),
        ];
    }

    /**
     * Get get const.
     */
    public static function getConst(): object
    {
        return (object) [
            'instansi_id' => config('siasn.const.instansi_id'),
            'satuan_kerja_id' => config('siasn.const.satuan_kerja_id'),
        ];
    }

    /**
     * Get mode.
     */
    public static function getWsTokenAge(): string
    {
        return config('siasn.token_age.ws');
    }

    /**
     * Get mode.
     */
    public static function getSsoTokenAge(): string
    {
        return config('siasn.token_age.sso');
    }
}
