<?php

use Kanekescom\Siasn\Api\Credentials\Apim;
use Kanekescom\Siasn\Api\Credentials\Sso;
use Kanekescom\Siasn\Api\Credentials\Token;

it('can generate apim token', function () {
    $apimToken = Apim::getToken()->object();

    expect($apimToken)->toHaveProperty('access_token');
});

it('can generate sso token', function () {
    $ssoToken = Sso::getToken()->object();

    expect($ssoToken)->toHaveProperty('access_token');
});

it('can generate apim token cache first', function () {
    $apimToken = Token::getApimToken();

    expect($apimToken)->toHaveProperty('access_token');
});

it('can generate sso token cache first', function () {
    $ssoToken = Token::getSsoToken();

    expect($ssoToken)->toHaveProperty('access_token');
});

it('can generate apim token same on cache', function () {
    $apimToken = Token::getApimToken();
    $cachedApimToken = cache('apim-token');

    expect($apimToken)->toBe($cachedApimToken);
});

it('can generate sso token same on cache', function () {
    $ssoToken = Token::getSsoToken();
    $cachedSsoToken = cache('sso-token');

    expect($ssoToken)->toBe($cachedSsoToken);
});

it('can generate apim token not same on cache', function () {
    $apimTokenObject = Apim::getToken()->object();
    $apimToken = Token::getApimToken();

    expect($apimTokenObject)->not()->toBe($apimToken);
});

it('can generate sso token not same on cache', function () {
    $ssoTokenObject = Sso::getToken()->object();
    $ssoToken = Token::getSsoToken();

    expect($ssoTokenObject)->not()->toBe($ssoToken);
});
