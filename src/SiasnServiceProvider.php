<?php

namespace Kanekes\Siasn\Api;

use Illuminate\Support\Facades\Http;
use Kanekes\Siasn\Api\Commands\Request\GetRequestCommand;
use Kanekes\Siasn\Api\Commands\Request\PostRequestCommand;
use Kanekes\Siasn\Api\Commands\Token\ForgetTokenCommand;
use Kanekes\Siasn\Api\Commands\Token\GenerateApimTokenCommand;
use Kanekes\Siasn\Api\Commands\Token\GenerateSsoTokenCommand;
use Kanekes\Siasn\Api\Commands\Token\GenerateTokenCommand;
use Kanekes\Siasn\Api\Contracts\TokenManager;
use Kanekes\Siasn\Api\Credentials\Token;
use Kanekes\Siasn\Api\Services\Config;
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
                ForgetTokenCommand::class,
                GenerateTokenCommand::class,
                GenerateApimTokenCommand::class,
                GenerateSsoTokenCommand::class,
                GetRequestCommand::class,
                PostRequestCommand::class,
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
        $this->app->singleton(Config::class, function () {
            return new Config;
        });

        $this->app->singleton(TokenManager::class, function ($app) {
            return new Token($app->make(Config::class));
        });

        $this->app->singleton(Siasn::class, function ($app) {
            return new Siasn;
        });

        $this->app->bind('siasn.http', function ($app) {
            return app(Siasn::class);
        });

        $this->registerHttpMacroHelpers();
    }

    protected function registerHttpMacroHelpers(): void
    {
        if (method_exists(Http::class, 'macroExists') && Http::macroExists('siasn')) {
            return;
        }

        Http::macro('siasn', function () {
            return app(Siasn::class);
        });
    }
}
