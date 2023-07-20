<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class FasterSMM extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fastersmm';
    }
}
