<?php

use Kanekes\Siasn\Api\Facades\Siasn;

it('can send a GET request to an endpoint', function () {
    $response = Siasn::get(config('siasn-api.tests.get_endpoint'));

    expect($response->successful())->toBeTrue();
});

it('can send a GET request with SSO to an endpoint', function () {
    $response = Siasn::withSso()->get(config('siasn-api.tests.get_with_sso_endpoint'));

    expect($response->successful())->toBeTrue();
});

it('can make an API request with Http::siasn()', function () {
    Http::fake([
        'https://example.com/*' => Http::response(['data' => 'test'], 200),
    ]);

    $response = Http::siasn()->get('https://example.com/some-endpoint');

    expect($response->json())->toHaveKey('data', 'test');
});
