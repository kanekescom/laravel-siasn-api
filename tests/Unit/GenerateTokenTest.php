<?php

namespace Kanekescom\Siasn\Api\Tests\Unit;

use Kanekescom\Siasn\Api\Credentials\Apim;
use Kanekescom\Siasn\Api\Credentials\Sso;
use Kanekescom\Siasn\Api\Credentials\Token;
use Kanekescom\Siasn\Api\Tests\TestCase;

class GenerateTokenTest extends TestCase
{
    public function test_generate_apim_token()
    {
        $this->assertObjectHasProperty('access_token', Apim::getToken()->object());
    }

    public function test_generate_sso_token()
    {
        $this->assertObjectHasProperty('access_token', Sso::getToken()->object());
    }

    public function test_generate_apim_token_cache_first()
    {
        $this->assertObjectHasProperty('access_token', Token::getApimToken());
    }

    public function test_generate_sso_token_cache_first()
    {
        $this->assertObjectHasProperty('access_token', Token::getSsoToken());
    }

    public function test_generate_apim_token_same_on_cache()
    {
        $this->assertSame(cache('apim-token'), Token::getApimToken());
    }

    public function test_generate_sso_token_same_on_cache()
    {
        $this->assertSame(cache('sso-token'), Token::getSsoToken());
    }

    public function test_generate_apim_token_not_same_on_cache()
    {
        $this->assertNotSame(Apim::getToken()->object(), Token::getApimToken());
    }

    public function test_generate_sso_token_not_same_on_cache()
    {
        $this->assertNotSame(Sso::getToken()->object(), Token::getSsoToken());
    }
}
