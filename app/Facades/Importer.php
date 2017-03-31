<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Description of Importer Facade Accessor
 */
class Importer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'importer';
    }
}