<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @method static StreamedResponse stream_export();
 */
class Export extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return \App\Contracts\Export::class;
    }
}
