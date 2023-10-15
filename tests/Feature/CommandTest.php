<?php

namespace Kanekescom\Siasn\Api\Tests\Feature;

use Kanekescom\Siasn\Api\Tests\TestCase;

class CommandTest extends TestCase
{
    public function test_generate_apim_token()
    {
        $this->artisan('siasn:apim-token')->assertSuccessful();
        $this->assertNotEmpty(cache('apim-token'));
    }

    public function test_generate_sso_token()
    {
        $this->artisan('siasn:sso-token')->assertSuccessful();
        $this->assertNotEmpty(cache('sso-token'));
    }

    public function test_generate_apim_token_fresh()
    {
        $this->artisan('siasn:apim-token', ['--fresh' => ''])->assertSuccessful();
        $this->assertNotEmpty(cache('apim-token'));
    }

    public function test_generate_sso_token_fresh()
    {
        $this->artisan('siasn:sso-token', ['--fresh' => ''])->assertSuccessful();
        $this->assertNotEmpty(cache('sso-token'));
    }

    public function test_generate_token()
    {
        $this->artisan('siasn:forget-token')->assertSuccessful();
        $this->artisan('siasn:token')->assertSuccessful();

        $this->assertNotEmpty(cache('apim-token'));
        $this->assertNotEmpty(cache('sso-token'));
    }

    public function test_generate_token_fresh()
    {
        $this->artisan('siasn:forget-token')->assertSuccessful();
        $this->artisan('siasn:token', ['--fresh' => ''])->assertSuccessful();

        $this->assertNotEmpty(cache('apim-token'));
        $this->assertNotEmpty(cache('sso-token'));
    }

    public function test_forget_token()
    {
        $this->artisan('siasn:token')->assertSuccessful();
        $this->artisan('siasn:forget-token')->assertSuccessful();

        $this->assertNull(cache('apim-token'));
        $this->assertNull(cache('sso-token'));
    }

    public function test_get_endpoint()
    {
        $this->artisan('siasn:get', ['endpoint' => env('SIASN_GET_ENDPOINT_TEST')])->assertSuccessful();
    }
}
