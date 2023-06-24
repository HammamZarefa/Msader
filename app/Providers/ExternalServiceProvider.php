<?php

namespace App\Providers;

use App\ExternalProviders\Nonvoip\Nonvoip;
use App\ExternalProviders\SmsActivate\SmsActivate;
use Illuminate\Support\ServiceProvider;

class ExternalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('smsactivate', function () {
            return new SmsActivate();
        });
        $this->app->bind('nonvoip', function () {
            return new Nonvoip();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
