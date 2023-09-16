<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TopCard extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sawacard';
    }
}
