<?php

use Kanekescom\Siasn\Api\Facades\Siasn;

it('can send get request endpoint', function () {
    $response = Siasn::get(env('SIASN_GET_REQUEST_ENDPOINT_TEST'));

    expect($response->successful())->toBeTrue();
});
