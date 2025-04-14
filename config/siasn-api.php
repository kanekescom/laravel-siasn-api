<?php

return [

    // Supported mode: "production", "training"
    'mode' => env('SIASN_MODE', 'training'),

    'apim' => [
        'production' => [
            'url' => env('SIASN_APIM_URL', 'https://apimws.bkn.go.id/oauth2/token'),
            'grant_type' => 'client_credentials',
            'username' => env('SIASN_APIM_USERNAME'),
            'password' => env('SIASN_APIM_PASSWORD'),
        ],

        'training' => [
            'url' => env('SIASN_APIM_URL_TRAINING', 'https://training-apimws.bkn.go.id/oauth2/token'),
            'grant_type' => 'client_credentials',
            'username' => env('SIASN_APIM_USERNAME_TRAINING', env('SIASN_APIM_USERNAME')),
            'password' => env('SIASN_APIM_PASSWORD_TRAINING', env('SIASN_APIM_PASSWORD')),
        ],
    ],

    'sso' => [
        'production' => [
            'url' => env('SIASN_SSO_URL', 'https://sso-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token'),
            'grant_type' => 'password',
            'client_id' => env('SIASN_SSO_CLIENT_ID'),
            'username' => env('SIASN_SSO_USERNAME'),
            'password' => env('SIASN_SSO_PASSWORD'),
            'generate' => (bool) env('SIASN_SSO_GENERATE'),
            'token_type' => env('SIASN_SSO_TOKEN_TYPE', 'Bearer'),
            'access_token' => env('SIASN_SSO_ACCESS_TOKEN'),
        ],

        'training' => [
            'url' => env('SIASN_SSO_URL_TRAINING', 'https://iam-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token'),
            'grant_type' => 'password',
            'client_id' => env('SIASN_SSO_CLIENT_ID_TRAINING', env('SIASN_SSO_CLIENT_ID')),
            'username' => env('SIASN_SSO_USERNAME_TRAINING', env('SIASN_SSO_USERNAME')),
            'password' => env('SIASN_SSO_PASSWORD_TRAINING', env('SIASN_SSO_PASSWORD')),
            'generate' => (bool) env('SIASN_SSO_GENERATE'),
            'token_type' => env('SIASN_SSO_TOKEN_TYPE_TRAINING', env('SIASN_SSO_TOKEN_TYPE', 'Bearer')),
            'access_token' => env('SIASN_SSO_ACCESS_TOKEN_TRAINING', env('SIASN_SSO_ACCESS_TOKEN')),
        ],
    ],

    'institution' => [
        'instansi_id' => env('SIASN_INSTITUTION_INSTANSI_ID'),
        'satuan_kerja_id' => env('SIASN_INSTITUTION_SATUAN_KERJA_ID'),
    ],

    'token_age' => [
        'apim' => (int) env('SIASN_APIM_TOKEN_AGE', 3600), // 1 hour
        'sso' => (int) env('SIASN_SSO_TOKEN_AGE', 43200), // 12 hours
    ],

    'debug' => (bool) env('SIASN_DEBUG', false),

    'enable_ssl_verification' => (bool) env('SIASN_ENABLE_SSL_VERIFICATION', true),

    'max_request_attempts' => (int) env('SIASN_REQUEST_ATTEMPTS', 3),

    'max_request_wait_attempts' => (int) env('SIASN_REQUEST_WAIT_ATTEMPTS', 30),

    'request_timeout' => (int) env('SIASN_REQUEST_TIMEOUT', 60),

    'tests' => [
        'get_endpoint' => env('SIASN_TEST_GET_ENDPOINT', 'https://apimws.bkn.go.id:8243/referensi_siasn/1/agama'),
        'get_with_sso_endpoint' => env('SIASN_TEST_GET_WITH_SSO_ENDPOINT', 'https://apimws.bkn.go.id:8243/apisiasn/1.0/referensi/ref-unor'),
    ],

];
