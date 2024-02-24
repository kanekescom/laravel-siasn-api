<?php

return [

    'mode' => env('SIASN_MODE', 'training'),

    'http_verify' => (bool) env('SIASN_HTTP_VERIFY', true),

    'debug' => (bool) env('SIASN_DEBUG', env('APP_DEBUG')),

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

    'const' => [
        'instansi_id' => env('SIASN_CONST_INSTANSI_ID'),
        'satuan_kerja_id' => env('SIASN_CONST_SATUAN_KERJA_ID'),
    ],

    'token_age' => [
        'apim' => env('SIASN_APIM_TOKEN_AGE', 3600 - 60),
        'sso' => env('SIASN_SSO_TOKEN_AGE', 43200 - 60),
    ],

    'max_request_attempts' => env('SIASN_REQUEST_ATTEMPTS', 3),

    'max_request_wait_attempts' => env('SIASN_REQUEST_WAIT_ATTEMPTS', 3),

    'timeout' => env('SIASN_TIMEOUT', 60),

];
