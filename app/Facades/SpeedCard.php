<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SpeedCard extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'speedcard';
    }
}
