<?php

namespace App\Contracts;

use Symfony\Component\HttpFoundation\StreamedResponse;

interface Export
{
    //KISS!!!
    function background_export(string $path) : bool;
    function stream_export() : StreamedResponse;
}
