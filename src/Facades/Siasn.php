<?php

namespace Kanekescom\Siasn\Api\Facades;

use Illuminate\Support\Facades\Facade;
use Kanekescom\Siasn\Api\Siasn as SiasnBuilder;

class Siasn extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @see \Kanekescom\Siasn\Siasn
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SiasnBuilder::class;
    }
}
