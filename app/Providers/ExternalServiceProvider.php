<?php

namespace App\Providers;

use App\ExternalProviders\CashSMM\CashSMM;
use App\ExternalProviders\FasterSMM\FasterSMM;
use App\ExternalProviders\N1Panel\N1Panel;
use App\ExternalProviders\Nonvoip\Nonvoip;
use App\ExternalProviders\SmsActivate\SmsActivate;
use App\ExternalProviders\SwProducts\SwProducts;
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
        $this->app->bind('cashsmm', function () {
            return new CashSMM();
        });
        $this->app->bind('n1panel', function () {
            return new N1Panel();
        });
        $this->app->bind('swproducts', function () {
            return new SwProducts();
        });
        $this->app->bind('fastersmm', function () {
            return new FasterSMM();
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
