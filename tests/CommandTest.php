<?php

namespace Kanekescom\Siasn\Api\Tests;

class CommandTest extends TestCase
{
    /** @test */
    public function can_generate_sso_token()
    {
        $this->artisan('siasn:sso-token')->assertSuccessful();

        $this->assertNotEmpty(cache('sso-token'));
    }

    /** @test */
    public function can_generate_ws_token()
    {
        $this->artisan('siasn:ws-token')->assertSuccessful();

        $this->assertNotEmpty(cache('ws-token'));
    }

    /** @test */
    public function can_generate_sso_token_fresh()
    {
        $this->artisan('siasn:sso-token', ['--fresh' => ''])->assertSuccessful();

        $this->assertNotEmpty(cache('sso-token'));
    }

    /** @test */
    public function can_generate_ws_token_fresh()
    {
        $this->artisan('siasn:ws-token', ['--fresh' => ''])->assertSuccessful();

        $this->assertNotEmpty(cache('ws-token'));
    }

    /** @test */
    public function can_generate_token()
    {
        $this->artisan('siasn:forget-token')->assertSuccessful();
        $this->artisan('siasn:token')->assertSuccessful();

        $this->assertNotEmpty(cache('sso-token'));
        $this->assertNotEmpty(cache('ws-token'));
    }

    /** @test */
    public function can_generate_token_fresh()
    {
        $this->artisan('siasn:forget-token')->assertSuccessful();
        $this->artisan('siasn:token', ['--fresh' => ''])->assertSuccessful();

        $this->assertNotEmpty(cache('sso-token'));
        $this->assertNotEmpty(cache('ws-token'));
    }

    /** @test */
    public function can_forget_token()
    {
        $this->artisan('siasn:token')->assertSuccessful();
        $this->artisan('siasn:forget-token')->assertSuccessful();

        $this->assertNull(cache('sso-token'));
        $this->assertNull(cache('ws-token'));
    }

    /** @test */
    public function can_get_data()
    {
        $this->artisan('siasn:get ' . env('SIASN_GET_ENDPOINT_TEST'))->assertSuccessful();
    }
}
