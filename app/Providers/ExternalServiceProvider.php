<?php

namespace App\Providers;

use App\ExternalProviders\CashSMM\CashSMM;
use App\ExternalProviders\SawaCard\SawaCard;
use App\ExternalProviders\SpeedCard\SpeedCard;
use App\ExternalProviders\TopCard\TopCard;
use App\ExternalProviders\WDM\WDM;
use App\ExternalProviders\FasterSMM\FasterSMM;
use App\ExternalProviders\Lord\Lord;
use App\ExternalProviders\N1Panel\N1Panel;
use App\ExternalProviders\Nonvoip\Nonvoip;
use App\ExternalProviders\SmsActivate\SmsActivate;
use App\ExternalProviders\SwProducts\SwProducts;
use App\ExternalProviders\XpCard\XpCard;
use App\ExternalProviders\As7ab\As7ab;
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
        $this->app->bind('lord', function () {
            return new Lord();
        });
        $this->app->bind('xpcard', function () {
            return new XpCard();
        });
        $this->app->bind('as7ab', function () {
            return new As7ab();
        });
        $this->app->bind('wdm', function () {
            return new WDM();
        });
        $this->app->bind('speedcard', function () {
            return new SpeedCard();
        });
        $this->app->bind('sawacard', function () {
            return new SawaCard();
        });
        $this->app->bind('topcard', function () {
            return new TopCard();
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
