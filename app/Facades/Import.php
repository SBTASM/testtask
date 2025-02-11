<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool import(String $path);
 */
class Import extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return \App\Contracts\Import::class;
    }
}
