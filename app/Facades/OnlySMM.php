<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class OnlySMM extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'onlysmm';
    }
}
