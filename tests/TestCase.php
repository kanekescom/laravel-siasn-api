<?php

namespace Kanekescom\Siasn\Api\Tests;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Kanekescom\Siasn\Api\SiasnServiceProvider::class,
        ];
    }
}
