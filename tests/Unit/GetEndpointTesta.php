<?php

namespace Kanekescom\Siasn\Api\Tests\Unit;

use Kanekescom\Siasn\Api\Facades\Siasn;
use Kanekescom\Siasn\Api\Tests\TestCase;

class GetEndpointTest extends TestCase
{
    public function test_get_endpoint()
    {
        $this->assertTrue(Siasn::get(env('SIASN_GET_ENDPOINT_TEST'))->successful());
    }
}
