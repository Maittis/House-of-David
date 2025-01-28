<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\TwilioSMSService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the TwilioSMSService to the container
        $this->app->bind(TwilioSMSService::class, function ($app) {
            return new TwilioSMSService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap(); // Enables Bootstrap-compatible pagination links
    }
}


