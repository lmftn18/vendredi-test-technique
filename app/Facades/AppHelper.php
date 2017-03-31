<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Description of AppHelper Facade Accessor
 */
class AppHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'appHelper';
    }
}