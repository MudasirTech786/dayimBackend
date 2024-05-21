<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\GoogleSheetsServices;
use PDF;

class GoogleSheetController extends Controller
{
    public function index(){
        return view('admin.sheets.index');
    }

    public function single($id){
        $data  = (new GoogleSheetsServices($id))->readSheets();
        $decodedData = json_decode(json_encode($data), true);

        return view('admin.sheets.single', ['data' => $decodedData]);
    }

    public function generatePDF(Request $request, $id)
    {        
            $data  = (new GoogleSheetsServices($id))->readSheets();
            $decodedData = json_decode(json_encode($data), true);

            // return view('pdf.pdfDocument', ['data' => $decodedData]);
            $pdf = PDF::loadView('pdf.pdfDocument', ['data' => $decodedData]);            
            return $pdf->download('document.pdf');
        
    }
}
