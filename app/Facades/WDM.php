<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class WDM extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'wdm';
    }
}
