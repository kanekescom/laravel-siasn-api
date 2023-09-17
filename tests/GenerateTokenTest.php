<?php

namespace Kanekescom\Siasn\Api\Tests;

use Kanekescom\Siasn\Api\Credentials\Sso;
use Kanekescom\Siasn\Api\Credentials\Token;
use Kanekescom\Siasn\Api\Credentials\Ws;

class GenerateTokenTest extends TestCase
{
    /** @test */
    public function can_generate_sso_token()
    {
        $token = Sso::getToken()->object();

        $this->assertObjectHasProperty('access_token', $token);
    }

    /** @test */
    public function can_generate_sso_token_cache_first()
    {
        $token = Token::getSsoToken();

        $this->assertObjectHasProperty('access_token', $token);
    }

    /** @test */
    public function can_generate_ws_token()
    {
        $token = Ws::getToken()->object();

        $this->assertObjectHasProperty('access_token', $token);
    }

    /** @test */
    public function can_generate_ws_token_cache_first()
    {
        $token = Token::getWsToken();

        $this->assertObjectHasProperty('access_token', $token);
    }

    /** @test */
    public function can_generate_sso_token_same_on_cache()
    {
        $token = Token::getSsoToken();

        $this->assertSame($token, cache('sso-token'));
    }

    /** @test */
    public function can_generate_sso_token_not_same_on_cache()
    {
        $token = Token::getSsoToken();
        $tokenNew = Sso::getToken()->object();

        $this->assertNotSame($token, $tokenNew);
    }

    /** @test */
    public function can_generate_ws_token_not_same_on_cache()
    {
        $token = Token::getWsToken();
        $tokenNew = Ws::getToken()->object();

        $this->assertNotSame($token, $tokenNew);
    }
}
