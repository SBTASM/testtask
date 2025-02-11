<?php

namespace  App\Contracts;

use Illuminate\Http\UploadedFile;

interface Import
{
    function  import(String $file) : bool;
}
