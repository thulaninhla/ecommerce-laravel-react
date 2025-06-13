<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // This tells Laravel to generate all URLs using https:// in production.
        if (env('APP_ENV') !== 'local') {
        URL::forceScheme('https');
        }
    }
}
