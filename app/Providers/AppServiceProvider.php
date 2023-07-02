<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        
        if (env('APP_ENV') !== 'local') {
            \Illuminate\Support\Facades\URL::forceScheme('http');
        }
        // enable https
        // \Illuminate\Support\Facades\URL::forceScheme('https');
    }
}
