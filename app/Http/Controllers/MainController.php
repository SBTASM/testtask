<?php

namespace App\Http\Controllers;

use App\Facades\Export;
use App\Facades\Import;
use App\Http\Requests\CsvFileRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MainController extends Controller
{
    public  function index(): View
    {
        return view('main.index');
    }

    public function upload(CsvFileRequest $request)
    {
        $path = $request
            ->file('csv_file')
            ->storeAs(
                implode(
                    '.',
                    [
                        bin2hex(Hash::make(time())), 'csv'
                    ]
                )
            )
        ;

        var_dump(Import::import($path));
    }

    public function export() : StreamedResponse
    {
        $filename = implode(".", [bin2hex(Hash::make(time()))]);
        $response = Export::stream_export();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"{$filename}\"");

        return $response;

    }
    //if im will be having fluent time, im implement background_export action.
}
