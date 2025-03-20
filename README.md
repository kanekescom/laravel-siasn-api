# Laravel SIASN API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kanekescom/laravel-siasn-api.svg?style=flat-square)](https://packagist.org/packages/kanekescom/laravel-siasn-api)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/kanekescom/laravel-siasn-api/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/kanekescom/laravel-siasn-api/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/kanekescom/laravel-siasn-api/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/kanekescom/laravel-siasn-api/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kanekescom/laravel-siasn-api.svg?style=flat-square)](https://packagist.org/packages/kanekescom/laravel-siasn-api)

A Laravel package for seamless integration with the SIASN REST API. This library is the abstraction of SIASN API for access from applications written with Laravel PHP Framework.

## Support Us

Want to provide tangible support? Use the following platforms to contribute to open-source software development:

- [Buy Me a Coffee](https://s.id/hadibmac)
- [Patreon](https://s.id/hadipatreon)
- [Saweria](https://s.id/hadisaweria)

Your support is greatly appreciated!

## Use Pro Version

We also offer a professional version. Contact us at **kanekescom@gmail.com** or **imachmadhadikurnia@gmail.com** (maintainer) for more details.

- Laravel SIASN Referensi Panel
- Laravel SIASN SIMPEG Panel
- SIMASN App (Sistem Informasi ASN)
- SIMATA App (Sistem Informasi Manajemen Talenta)

## Installation

Install the package via Composer:

```bash
composer require kanekescom/laravel-siasn-api
```

Publish the config file:

```bash
php artisan vendor:publish --tag="siasn-api-config"
```

Or complete all installations with:

```bash
php artisan siasn-api:install
```

## Usage

### Token Generator

Generate an APIM Token:

```bash
php artisan siasn:apim-token
```

Generate an SSO Token:

```bash
php artisan siasn:sso-token
```

Generate both APIM and SSO Tokens:

```bash
php artisan siasn:token
```

Use `--fresh` to always request a new token.

### Remove Tokens

```bash
php artisan siasn:forget-token
```

### Available Token Methods

```php
Token::getNewApimToken(); // Always request a new APIM token
Token::getApimToken(); // Request an APIM token

Token::getNewSsoToken(); // Always request a new SSO token
Token::getSsoToken(); // Request an SSO token

Token::forget(); // Remove APIM and SSO tokens
```

### Send a Request Using Commands

#### GET Request:

```bash
php artisan siasn:get {endpoint}
```

Example:

```bash
php artisan siasn:get https://apimws.bkn.go.id:8243/apisiasn/1.0/referensi/ref-unor
```

#### POST Request:

```bash
php artisan siasn:post {endpoint}
```

### Send a Request Using Class

The `Siasn` class uses Laravel's `Http` class (`Illuminate\Support\Facades\Http`):

```php
Siasn::get($endpoint, $params);
```

For dual authentication (SSO), use:

```php
Siasn::withSso()->get($endpoint, $params);
```

## Testing

```bash
composer test
```

## Our Other Cool Packages

### Referensi APIs

- [Laravel SIASN Referensi API](https://github.com/kanekescom/laravel-siasn-referensi-api)
- [Laravel SIASN Referensi Backend](https://github.com/kanekescom/laravel-siasn-referensi)

### SIASNAPI-SIMPEG APIs

- [Laravel SIASN SIMPEG API](https://github.com/kanekescom/laravel-siasn-simpeg-api)
- [Laravel SIASN SIMPEG Backend](https://github.com/kanekescom/laravel-siasn-simpeg)

## Changelog

See [CHANGELOG](CHANGELOG.md) for recent updates.

## Contributing

See [CONTRIBUTING](CONTRIBUTING.md) for contribution guidelines.

## Security Vulnerabilities

See our [security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Achmad Hadi Kurnia](https://github.com/achmadhadikurnia)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). See [License File](LICENSE.md) for details.
