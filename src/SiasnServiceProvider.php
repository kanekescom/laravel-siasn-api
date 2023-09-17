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
        $this->mergeConfigFrom(__DIR__.'/../config/siasn.php', 'siasn');

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
            __DIR__.'/../config/siasn.php' => config_path('siasn.php'),
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
            Commands\GenerateSsoToken::class,
            Commands\GenerateWsToken::class,
            Commands\GetData::class,
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
