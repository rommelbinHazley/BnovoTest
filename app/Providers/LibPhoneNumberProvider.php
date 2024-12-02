<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use libphonenumber\PhoneNumberUtil;

class LibPhoneNumberProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $this->app->singleton('libphonenumber', fn ($app) => PhoneNumberUtil::getInstance());
        $this->app->alias('libphonenumber', 'libphonenumber\PhoneNumberUtil');
    }

    /**
     * @return string[]
     */
    public function provides(): array
    {
        return ['libphonenumber', 'libphonenumber\PhoneNumberUtil'];
    }
}
