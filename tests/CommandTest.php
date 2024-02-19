<?php

it('can generate apim token', function () {
    $this->artisan('siasn:apim-token')->assertSuccessful();

    $this->assertNotEmpty(cache('apim-token'));
});

it('can generate sso token', function () {
    $this->artisan('siasn:sso-token')->assertSuccessful();

    $this->assertNotEmpty(cache('sso-token'));
});

it('can generate apim token fresh', function () {
    $this->artisan('siasn:apim-token', ['--fresh' => ''])->assertSuccessful();

    $this->assertNotEmpty(cache('apim-token'));
});

it('can generate sso token fresh', function () {
    $this->artisan('siasn:sso-token', ['--fresh' => ''])->assertSuccessful();

    $this->assertNotEmpty(cache('sso-token'));
});

it('can generate token', function () {
    $this->artisan('siasn:forget-token')->assertSuccessful();
    $this->artisan('siasn:token')->assertSuccessful();

    $this->assertNotEmpty(cache('apim-token'));
    $this->assertNotEmpty(cache('sso-token'));
});

it('can generate token fresh', function () {
    $this->artisan('siasn:forget-token')->assertSuccessful();
    $this->artisan('siasn:token', ['--fresh' => ''])->assertSuccessful();

    $this->assertNotEmpty(cache('apim-token'));
    $this->assertNotEmpty(cache('sso-token'));
});

it('can forget token', function () {
    $this->artisan('siasn:token')->assertSuccessful();
    $this->artisan('siasn:forget-token')->assertSuccessful();

    $this->assertNull(cache('apim-token'));
    $this->assertNull(cache('sso-token'));
});

it('can get endpoint', function () {
    $this->artisan('siasn:get', ['endpoint' => env('SIASN_GET_REQUEST_ENDPOINT_TEST')])
        ->expectsQuestion('Write the parameters in JSON form here', '')
        ->assertSuccessful();
});

// it('can post endpoint', function () {
//     $this->artisan('siasn:post', ['endpoint' => env('SIASN_POST_REQUEST_ENDPOINT_TEST')])
//         ->expectsQuestion('Write the parameters in JSON form here', json_encode(['pns_orang_id' => env('PNS_ORANG_ID')]))
//         ->assertSuccessful();
// });
