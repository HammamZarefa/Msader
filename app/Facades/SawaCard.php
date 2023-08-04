<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SawaCard extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sawacard';
    }
}
