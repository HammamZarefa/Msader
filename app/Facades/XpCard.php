<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class XpCard extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'xpcard';
    }
}
