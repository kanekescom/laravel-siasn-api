<?php

return [

    // Supported mode: "production", "training"
    'mode' => env('SIASN_MODE', 'training'),

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
        'apim' => (int) env('SIASN_APIM_TOKEN_AGE', 3600 - 60),
        'sso' => (int) env('SIASN_SSO_TOKEN_AGE', 43200 - 60),
    ],

    'debug' => (bool) env('SIASN_DEBUG', env('APP_DEBUG')),

    'enable_ssl_verification' => (bool) env('SIASN_ENABLE_SSL_VERIFICATION', true),

    'max_request_attempts' => (int) env('SIASN_REQUEST_ATTEMPTS', 3),

    'max_request_wait_attempts' => (int) env('SIASN_REQUEST_WAIT_ATTEMPTS', 30),

    'request_timeout' => (int) env('SIASN_REQUEST_TIMEOUT', 60),

];
