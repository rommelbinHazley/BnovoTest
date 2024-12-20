<?php

namespace App\Providers;

use App\Services\GuestService;
use App\Services\IGuestService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IGuestService::class, GuestService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
