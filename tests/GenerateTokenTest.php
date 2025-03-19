<?php

use Kanekes\Siasn\Api\Credentials\Apim;
use Kanekes\Siasn\Api\Credentials\Sso;
use Kanekes\Siasn\Api\Credentials\Token;

it('can generate an APIM token', function () {
    $apimToken = app(Apim::class)->getToken();

    expect($apimToken)->toHaveProperty('access_token');
});

it('can generate an SSO token', function () {
    $ssoToken = app(Sso::class)->getToken();

    expect($ssoToken)->toHaveProperty('access_token');
});

it('can generate an APIM token using cache first', function () {
    $apimToken = app(Token::class)->getApimToken();

    expect($apimToken)->toHaveProperty('access_token');
});

it('can clear cache and generate an APIM token using cache first', function () {
    $apimToken = app(Token::class)->getNewApimToken();

    expect($apimToken)->toHaveProperty('access_token');
});

it('can generate an SSO token using cache first', function () {
    $ssoToken = app(Token::class)->getSsoToken();

    expect($ssoToken)->toHaveProperty('access_token');
});

it('can clear cache and generate an SSO token using cache first', function () {
    $ssoToken = app(Token::class)->getNewSsoToken();

    expect($ssoToken)->toHaveProperty('access_token');
});

it('can generate the same APIM token from cache', function () {
    $apimToken = app(Token::class)->getApimToken();
    $cachedApimToken = cache('apim-token');

    expect($apimToken)->toBe($cachedApimToken);
});

it('can generate the same SSO token from cache', function () {
    $ssoToken = app(Token::class)->getSsoToken();
    $cachedSsoToken = cache('sso-token');

    expect($ssoToken)->toBe($cachedSsoToken);
});

it('can generate an APIM token that differs from cache', function () {
    $apimTokenObject = app(Apim::class)->getToken();
    $apimToken = app(Token::class)->getApimToken();

    expect($apimTokenObject)->not()->toBe($apimToken);
});

it('can generate an SSO token that differs from cache', function () {
    $ssoTokenObject = app(Sso::class)->getToken();
    $ssoToken = app(Token::class)->getSsoToken();

    expect($ssoTokenObject)->not()->toBe($ssoToken);
});
