<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Description of AirTable Facade Accessor
 */
class AirTable extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'airTable';
    }
}