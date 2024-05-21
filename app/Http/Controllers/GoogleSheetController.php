<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\GoogleSheetsServices;
use App\Models\UserSheet;
use PDF;
use Illuminate\Support\Facades\Auth;

class GoogleSheetController extends Controller
{
    public function index(){
        $user = Auth::user()->id;
        $sheets = UserSheet::where('user_id', $user )->get();
        return view('admin.sheets.index', compact('sheets'));
    }

    public function single($id){
        $data  = (new GoogleSheetsServices($id))->readSheets();
        $decodedData = json_decode(json_encode($data), true);

        return view('admin.sheets.single', ['data' => $decodedData, 'id' => $id]);
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
