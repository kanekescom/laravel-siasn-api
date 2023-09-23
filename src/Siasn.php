<?php

namespace Kanekescom\Siasn\Api;

use Illuminate\Support\Facades\Http;
use Kanekescom\Siasn\Api\Credentials\Token;

class Siasn
{
    private $response;

    /**
     * Create a new instance.
     */
    public function __construct()
    {
        $apimToken = Token::getApimToken();
        $ssoToken = Token::getSsoToken();

        $this->response = Http::retry(3, 100)
            ->withOptions([
                'debug' => SiasnConfig::getDebug(),
            ])->withHeaders([
                'Auth' => "{$ssoToken->token_type} {$ssoToken->access_token}",
            ])->withToken(
                $apimToken->access_token
            );
    }

    /**
     * Handle dynamic method calls.
     *
     * @param  string  $method
     * @param  array  $parameters
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->response, $method)) {
            return call_user_func_array([$this->response, $method], $parameters);
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }

    /**
     * Handle dynamic static method calls.
     *
     * @param  string  $method
     * @param  array  $parameters
     */
    public static function __callStatic($method, $parameters)
    {
        if (method_exists((new static)->response, $method)) {
            return call_user_func_array([(new static)->response, $method], $parameters);
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }
}
