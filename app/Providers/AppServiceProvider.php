<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Setting Google Cloud Account
        putenv('GOOGLE_CLOUD_PROJECT=small-talk-principal-uyng');
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . base_path('small-talk-principal-uyng-9ffd46c7b77d.json'));

        // Force HTTPS
        if (env('APP_ENV') == 'production') {
            \URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
