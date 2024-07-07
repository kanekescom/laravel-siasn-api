<?php

namespace Kanekescom\Siasn\Api\Helpers;

class Config
{
    public static function getMode(): string
    {
        return config('siasn-api.mode');
    }

    /**
     * @noinspection PhpUnused
     */
    public static function isProduction(): bool
    {
        return self::getMode() === 'production';
    }

    /**
     * @noinspection PhpUnused
     */
    public static function isTraining(): bool
    {
        return self::getMode() === 'training';
    }

    public static function getDebug(): bool
    {
        return config('siasn-api.debug');
    }

    public static function getEnableSslVerification(): bool
    {
        return config('siasn-api.enable_ssl_verification');
    }

    public static function getApimCredential(): object
    {
        return (object) [
            'url' => config('siasn-api.apim.'.self::getMode().'.url'),
            'username' => config('siasn-api.apim.'.self::getMode().'.username'),
            'password' => config('siasn-api.apim.'.self::getMode().'.password'),
            'grant_type' => config('siasn-api.apim.'.self::getMode().'.grant_type'),
        ];
    }

    public static function getSsoCredential(): object
    {
        return (object) [
            'url' => config('siasn-api.sso.'.self::getMode().'.url'),
            'client_id' => config('siasn-api.sso.'.self::getMode().'.client_id'),
            'username' => config('siasn-api.sso.'.self::getMode().'.username'),
            'password' => config('siasn-api.sso.'.self::getMode().'.password'),
            'grant_type' => config('siasn-api.sso.'.self::getMode().'.grant_type'),
        ];
    }

    /**
     * @noinspection PhpUnused
     */
    public static function getConst(): object
    {
        return (object) [
            'instansi_id' => config('siasn-api.const.instansi_id'),
            'satuan_kerja_id' => config('siasn-api.const.satuan_kerja_id'),
        ];
    }

    /**
     * Get mode.
     */
    public static function getApimTokenAge(): ?int
    {
        return config('siasn-api.token_age.apim');
    }

    /**
     * Get mode.
     */
    public static function getSsoTokenAge(): ?int
    {
        return config('siasn-api.token_age.sso');
    }
}
