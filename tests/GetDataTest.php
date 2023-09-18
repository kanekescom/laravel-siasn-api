<?php

namespace Kanekescom\Siasn\Api\Tests;

use Kanekescom\Siasn\Api\Facades\Siasn;

class GetDataTest extends TestCase
{
    /** @test */
    public function can_get_data_successful_status()
    {
        $response = Siasn::get(env('SIASN_GET_ENDPOINT_TEST'));

        $this->assertTrue($response->successful());
    }
}
