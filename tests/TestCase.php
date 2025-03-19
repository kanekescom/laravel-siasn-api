<?php

namespace Kanekes\Siasn\Api\Tests;

use Kanekes\Siasn\Api\SiasnServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            SiasnServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('cache.default', 'array');
    }
}
