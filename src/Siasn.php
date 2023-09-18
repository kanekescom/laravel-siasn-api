<?php

namespace Kanekescom\Siasn\Api;

use Illuminate\Support\Facades\Http;
use Kanekescom\Siasn\Api\Credentials\Token;

class Siasn
{
    private $request;

    public function __construct($base_url = null)
    {
        $ssoToken = Token::getSsoToken();
        $wsToken = Token::getWsToken();

        $this->request = Http::retry(3, 100)
            ->withOptions([
                'debug' => SiasnConfig::getDebug(),
            ])->withHeaders([
                'Auth' => "{$ssoToken->token_type} {$ssoToken->access_token}",
            ])->withToken(
                $wsToken->access_token
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
        if (method_exists($this->request, $method)) {
            return call_user_func_array([$this->request, $method], $parameters);
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
        if (method_exists((new static)->request, $method)) {
            return call_user_func_array([(new static)->request, $method], $parameters);
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }
}
