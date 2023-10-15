<?php

namespace Kanekescom\Siasn\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class SiasnServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        $this->offerPublishing();

        $this->registerCommands();

        $this->registerHttpMacroHelpers();
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/siasn_api.php', 'siasn_api');

        // Register the service the package provides.
        $this->app->singleton(Siasn::class, function ($app) {
            return new Siasn;
        });
    }

    /**
     * Offer publishing.
     */
    protected function offerPublishing(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        if (! function_exists('config_path')) {
            // function not available and 'publish' not relevant in Lumen
            return;
        }

        $this->publishes([
            __DIR__.'/../config/siasn_api.php' => config_path('siasn_api.php'),
        ], 'config');
    }

    /**
     * Register commands.
     */
    protected function registerCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Commands\ForgetToken::class,
            Commands\GenerateToken::class,
            Commands\GenerateApimToken::class,
            Commands\GenerateSsoToken::class,
            Commands\GetEndpoint::class,
        ]);
    }

    /**
     * Register HTTP Macros.
     */
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
