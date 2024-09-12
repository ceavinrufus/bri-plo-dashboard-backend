<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelController extends Controller
{
    public function index()
    {
        return view('upload-excel', ['title' => 'Upload Excel']);
    }
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();

        $import = new ExcelImport($worksheet);

        // Convert the worksheet to array and filter out hidden rows/columns
        $data = $import->array($worksheet->toArray());
        // dd($data);

        return view('upload-excel', ['data' => $data, 'title' => 'Upload Excel']);
    }
}
