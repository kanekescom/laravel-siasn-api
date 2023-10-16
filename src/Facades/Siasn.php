<?php

namespace Kanekescom\Siasn\Api\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kanekescom\Siasn\Api\Siasn
 */
class Siasn extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Kanekescom\Siasn\Api\Siasn::class;
    }
}
