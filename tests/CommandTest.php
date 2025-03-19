<?php

it('can generate an APIM token', function () {
    $this->artisan('siasn:apim-token')->assertSuccessful();

    $this->assertNotEmpty(cache('apim-token'));
});

it('can generate an SSO token', function () {
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

// it('can send a GET request to an endpoint', function () {
//     $this->artisan('siasn:get', ['endpoint' => env('SIASN_GET_REQUEST_ENDPOINT_TEST')])
//         ->expectsQuestion('Write the parameters in JSON form here', '')
//         ->assertSuccessful();
// });

// it('can send a POST request to an endpoint', function () {
//     $this->artisan('siasn:post', ['endpoint' => ''])
//         ->expectsQuestion('Write the parameters in JSON form here', json_encode([]))
//         ->assertSuccessful();
// });
