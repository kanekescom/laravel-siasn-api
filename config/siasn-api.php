<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mode
    |--------------------------------------------------------------------------
    |
    | This value determines the "mode" your SIASN API is currently running in.
    | This may determine how you prefer to configure various services the
    | application utilizes.
    |
    | Supported: "training", "production"
    |
    */

    'mode' => env('SIASN_MODE', 'training'),

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | When in debug mode, detailed error messages with stack traces will be
    | shown on every error that occurs within your application. If disabled,
    | a simple generic error page is shown.
    |
    */

    'http_verify' => (bool) env('SIASN_HTTP_VERIFY', true),

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | When in debug mode, detailed error messages with stack traces will be
    | shown on every error that occurs within your application. If disabled,
    | a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('SIASN_DEBUG', env('APP_DEBUG')),

    /*
    |--------------------------------------------------------------------------
    | Credentials
    |--------------------------------------------------------------------------
    |
    | This options is for storing credentials for SIASN API Manager and SIASN
    | SSO API
    |
    */

    'apim' => [
        'production' => [
            'url' => 'https://apimws.bkn.go.id/oauth2/token',
            'grant_type' => 'client_credentials',
            'username' => env('SIASN_APIM_USERNAME'),
            'password' => env('SIASN_APIM_PASSWORD'),
        ],

        'training' => [
            'url' => 'https://training-apimws.bkn.go.id/oauth2/token',
            'grant_type' => 'client_credentials',
            'username' => env('TRAINING_SIASN_APIM_USERNAME'),
            'password' => env('TRAINING_SIASN_APIM_PASSWORD'),
        ],
    ],

    'sso' => [
        'production' => [
            'url' => 'https://sso-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token',
            'grant_type' => 'password',
            'client_id' => env('SIASN_SSO_CLIENT_ID'),
            'username' => env('SIASN_SSO_USERNAME'),
            'password' => env('SIASN_SSO_PASSWORD'),
        ],

        'training' => [
            'url' => 'https://iam-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token',
            'grant_type' => 'password',
            'client_id' => env('TRAINING_SIASN_SSO_CLIENT_ID'),
            'username' => env('TRAINING_SIASN_SSO_USERNAME'),
            'password' => env('TRAINING_SIASN_SSO_PASSWORD'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Constanta
    |--------------------------------------------------------------------------
    |
    | This options is for storing the param for SIASN API.
    |
    */

    'const' => [
        'instansi_id' => env('SIASN_CONST_INSTANSI_ID'),
        'satuan_kerja_id' => env('SIASN_CONST_SATUAN_KERJA_ID'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Token Age
    |--------------------------------------------------------------------------
    |
    | This option is to cache token ages in seconds.
    |
    */

    'token_age' => [
        'apim' => env('SIASN_APIM_TOKEN_AGE', 3600 - 60),
        'sso' => env('SIASN_SSO_TOKEN_AGE', 43200 - 60),
    ],

    /*
    |--------------------------------------------------------------------------
    | Timeout
    |--------------------------------------------------------------------------
    |
    | This option determine the time limit for getting a response in seconds
    |
    */

    'timeout' => env('SIASN_TIMEOUT', 60),

];
