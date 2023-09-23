<?php

namespace Kanekescom\Siasn\Api\Tests;

use Kanekescom\Siasn\Api\Credentials\Apim;
use Kanekescom\Siasn\Api\Credentials\Sso;
use Kanekescom\Siasn\Api\Credentials\Token;

class GenerateTokenTest extends TestCase
{
    /** @test */
    public function can_generate_apim_token()
    {
        $token = Apim::getToken()->object();

        $this->assertObjectHasProperty('access_token', $token);
    }

    /** @test */
    public function can_generate_apim_token_cache_first()
    {
        $token = Token::getApimToken();

        $this->assertObjectHasProperty('access_token', $token);
    }

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
    public function can_generate_sso_token_same_on_cache()
    {
        $token = Token::getSsoToken();

        $this->assertSame($token, cache('sso-token'));
    }

    /** @test */
    public function can_generate_apim_token_not_same_on_cache()
    {
        $token = Token::getApimToken();
        $tokenNew = Apim::getToken()->object();

        $this->assertNotSame($token, $tokenNew);
    }

    /** @test */
    public function can_generate_sso_token_not_same_on_cache()
    {
        $token = Token::getSsoToken();
        $tokenNew = Sso::getToken()->object();

        $this->assertNotSame($token, $tokenNew);
    }
}
