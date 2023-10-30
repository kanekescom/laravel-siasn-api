<?php

use Kanekescom\Siasn\Api\Facades\Siasn;

it('can send post request endpoint', function () {
    $response = Siasn::withSso()->post(env('SIASN_POST_REQUEST_ENDPOINT_TEST'), ['pns_orang_id' => env('PNS_ORANG_ID')]);

    expect($response->successful())->toBeTrue();
});
