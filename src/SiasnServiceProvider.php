<?php

namespace Kanekescom\Siasn\Api;

use Illuminate\Support\Facades\Http;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SiasnServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-siasn-api')
            ->hasConfigFile()
            ->hasCommands([
                Commands\ForgetTokenCommand::class,
                Commands\GenerateTokenCommand::class,
                Commands\GenerateApimTokenCommand::class,
                Commands\GenerateSsoTokenCommand::class,
                Commands\GetRequestEndpointCommand::class,
                Commands\PostRequestEndpointCommand::class,
            ])
            ->hasInstallCommand(function ($command) {
                $command
                    ->startWith(function ($command) {
                        $command->info('Hello, and welcome to my great laravel package!');
                    })
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('kanekescom/laravel-siasn-api')
                    ->endWith(function ($command) {
                        $command->info('Have a great day!');
                    });
            });
    }

    public function packageRegistered(): void
    {
        $this->registerHttpMacroHelpers();
    }

    protected function registerHttpMacroHelpers(): void
    {
        if (! method_exists(Http::class, 'macro')) { // Lumen
            return;
        }

        Http::macro('siasn', function () {
            return new Siasn;
        });
    }
}
