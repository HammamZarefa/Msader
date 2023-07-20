<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class N1Panel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'n1panel';
    }
}
