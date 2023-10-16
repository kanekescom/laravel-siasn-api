<?php

namespace Kanekescom\Siasn\Api;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SiasnServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-siasn-api')
            ->hasConfigFile()
            ->hasCommand(Commands\ForgetTokenCommand::class)
            ->hasCommand(Commands\GenerateTokenCommand::class)
            ->hasCommand(Commands\GenerateApimTokenCommand::class)
            ->hasCommand(Commands\GenerateSsoTokenCommand::class)
            ->hasCommand(Commands\GetRequestEndpointCommand::class)
            ->hasCommand(Commands\PostRequestEndpointCommand::class);
    }

    public function packageRegistered(): void
    {
        $this->registerHttpMacroHelpers();
    }

    protected function registerHttpMacroHelpers(): void
    {
        if (! method_exists(\Illuminate\Support\Facades\Http::class, 'macro')) { // Lumen
            return;
        }

        \Illuminate\Support\Facades\Http::macro('siasn', function () {
            return new Siasn;
        });
    }
}
