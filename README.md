# Laravel SIASN API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kanekescom/laravel-siasn-api.svg?style=flat-square)](https://packagist.org/packages/kanekescom/laravel-siasn-api)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/kanekescom/laravel-siasn-api/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/kanekescom/laravel-siasn-api/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/kanekescom/laravel-siasn-api/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/kanekescom/laravel-siasn-api/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kanekescom/laravel-siasn-api.svg?style=flat-square)](https://packagist.org/packages/kanekescom/laravel-siasn-api)

SIASN REST API Client for Laravel.
This library is the abstraction of SIASN API for access from applications written with Laravel PHP Framework.

## Support us

Want to provide tangible support? Use the following platform to contribute to open-source software developers. Every contribution you make is a significant boost to continue building and enhancing technology that benefits everyone.

- Buy Me a Coffee https://s.id/hadibmac
- Patreon https://s.id/hadipatreon
- Saweria https://s.id/hadisaweria

We highly appreciate you sending us a few cups of coffee to accompany us while writing code. Super, thanks.

## Use pro version

We also offer a professional version. We're excited for you to try it out, as it allows us to consistently deliver high-quality software. Feel free to contact us at kanekescom@gmail.com or @achmadhadikurnia (maintainer) for further information.

- Laravel SIASN Referensi Panel
- Laravel SIASN SIMPEG Panel
- SIMPEGDA App

## Installation

You can install the package via composer:

```bash
composer require kanekescom/laravel-siasn-api
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="siasn-api-config"
```

This is the contents of the published config file:

```php
// config/siasn-api.php
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
```

Or, all installations can be completed with the installation command:

```bash
php artisan siasn-api:install
```

## Usage

### Token Generator

Generate an APIM Token

```bash
php artisan siasn:apim-token
```

Generate an SSO Token

```bash
php artisan siasn:sso-token
```

Generate an APIM and SSO Token

```bash
php artisan siasn:token
```

You can add the `--fresh` option to always request a new token

### Remove Token

Remove an APIM and SSO Token

```bash
php artisan siasn:forget-token
```

### Send Request

Send a GET request to endpoint of SIASN API

```bash
php artisan siasn:get {endpoint}
```

An example to get the referensi unor

```bash
php artisan siasn:get https://apimws.bkn.go.id:8243/apisiasn/1.0/referensi/ref-unor
```

Send a POST request to endpoint of SIASN API

```bash
php artisan siasn:post {endpoint}
```

### Using Class

The Siasn class uses the Http class (Illuminate\Support\Facades\Http) from Laravel. So you can use it just like you would use that class.

```php
Siasn::get($endpoint, $params)
```

We added the `withSso()` method for dual authentication purposes required by BKN. So you just need to add this method if needed, making it like the following.

```php
Siasn::withSso()->get($endpoint, $params)
```

## Testing

```bash
composer test
```

## Our other cool packages

Need a package for other BKN's Web Service APIs? Consider installing our packages for seamless integration.

### Referensi APIs

- https://github.com/kanekescom/laravel-siasn-referensi-api as API client

- https://github.com/kanekescom/laravel-siasn-referensi as backend

### SIASNAPI-SIMPEG APIs

- https://github.com/kanekescom/laravel-siasn-simpeg-api as API client

- https://github.com/kanekescom/laravel-siasn-simpeg as backend

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Achmad Hadi Kurnia](https://github.com/kanekescom)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
