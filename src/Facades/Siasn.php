<?php

namespace Kanekescom\Siasn\Api\Facades;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Facade;

/**
 * @method static PendingRequest withSso()
 *
 * @see \Kanekescom\Siasn\Api\Siasn
 */
class Siasn extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Kanekescom\Siasn\Api\Siasn::class;
    }
}
