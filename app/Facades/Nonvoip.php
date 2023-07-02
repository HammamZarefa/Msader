<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Nonvoip extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'nonvoip';
    }
}
