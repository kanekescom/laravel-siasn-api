<?php

namespace Kanekes\Siasn\Api\Facades;

use Illuminate\Support\Facades\Facade;
use Kanekes\Siasn\Api\Siasn as SiasnClient;

/**
 * @method static \Illuminate\Http\Client\PendingRequest withSso()
 * @method static \Illuminate\Http\Client\Response get(string $url, array $query = [])
 * @method static \Illuminate\Http\Client\Response post(string $url, array $data = [])
 * @method static \Illuminate\Http\Client\Response put(string $url, array $data = [])
 * @method static \Illuminate\Http\Client\Response patch(string $url, array $data = [])
 * @method static \Illuminate\Http\Client\Response delete(string $url, array $data = [])
 */
class Siasn extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SiasnClient::class;
    }
}
