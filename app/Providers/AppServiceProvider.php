<?php

namespace App\Providers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
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
    Schema::defaultStringLength(191);

    Http::globalOptions([
        'curl' => [
            CURLOPT_SSL_OPTIONS => CURLSSLOPT_NATIVE_CA,
        ],
    ]); 
    Blade::component('tide-form', \App\View\Components\TideForm::class);
}

}


