<?php

namespace App\Http\Controllers;

use App\Facades\Export;
use App\Facades\Import;
use App\Helpers\Utilities;
use App\Http\Requests\CsvFileRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MainController extends Controller
{
    use Utilities;
    public  function index(): View
    {
        return view('main.index');
    }

    /**
     * Я не тестував цей екшин на вразливості(XSS, Injection). Якщо треба, то зроблю.
     * @param CsvFileRequest $request
     * @return RedirectResponse
     */
    public function upload(CsvFileRequest $request): RedirectResponse
    {
        $path = $request
            ->file('csv_file')
            ->storeAs(implode('.', [$this->genFileName(), 'csv']))
        ;

        Import::import($path);

        return redirect()->to(route('main.index'));
    }

    public function export() : StreamedResponse
    {
        $filename = implode(".", [$this->genFileName()]);
        $response = Export::stream_export();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"{$filename}\"");

        return $response;

    }

    //if im will be having fluent time, im implement background_export action.
}
