<?php

it('can generate APIM token', function () {
    $this->artisan('siasn:apim-token')->assertSuccessful();

    $this->assertNotEmpty(cache('apim-token'));
});

it('can generate SSO token', function () {
    $this->artisan('siasn:sso-token')->assertSuccessful();

    $this->assertNotEmpty(cache('sso-token'));
});

it('can generate a fresh APIM token', function () {
    $this->artisan('siasn:apim-token', ['--fresh' => ''])->assertSuccessful();

    $this->assertNotEmpty(cache('apim-token'));
});

it('can generate a fresh SSO token', function () {
    $this->artisan('siasn:sso-token', ['--fresh' => ''])->assertSuccessful();

    $this->assertNotEmpty(cache('sso-token'));
});

it('can generate both APIM and SSO tokens', function () {
    $this->artisan('siasn:forget-token')->assertSuccessful();
    $this->artisan('siasn:token')->assertSuccessful();

    $this->assertNotEmpty(cache('apim-token'));
    $this->assertNotEmpty(cache('sso-token'));
});

it('can generate fresh APIM and SSO tokens', function () {
    $this->artisan('siasn:forget-token')->assertSuccessful();
    $this->artisan('siasn:token', ['--fresh' => ''])->assertSuccessful();

    $this->assertNotEmpty(cache('apim-token'));
    $this->assertNotEmpty(cache('sso-token'));
});

it('can forget both APIM and SSO tokens', function () {
    $this->artisan('siasn:token')->assertSuccessful();
    $this->artisan('siasn:forget-token')->assertSuccessful();

    $this->assertNull(cache('apim-token'));
    $this->assertNull(cache('sso-token'));
});

it('can successfully send a GET request to the SIASN endpoint', function () {
    $this->artisan('siasn:get', ['endpoint' => config('siasn-api.tests.get_endpoint')])
        ->expectsQuestion('Enter JSON parameters (optional)', '')
        ->assertSuccessful();
});

it('can successfully send a GET request with SSO to the SIASN endpoint', function () {
    $this->artisan('siasn:get', [
        'endpoint' => config('siasn-api.tests.get_with_sso_endpoint'),
        '--with-sso' => true,
    ])
        ->expectsQuestion('Enter JSON parameters (optional)', '')
        ->assertSuccessful();
});
