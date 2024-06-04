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
        
        $allSheetData = []; // Initialize an array to hold the data of all sheets
        $totalBookings = 0;
        $totalReceived = 0;
        $totalBalance = 0;

        foreach ($sheets as $sheet) {
            $totalBookings = $totalBookings + 1;
            // return $sheet->sheet_no;
            $data  = (new GoogleSheetsServices($sheet->sheet_no))->readSheets();
            $decodedData = json_decode(json_encode($data), true);
                
            $totalPrice = $decodedData['values'][4][2];
            $registrationNumber = $decodedData['values'][4][4];
            $productCode = $decodedData['values'][5][7];
            $paidAmount = (float) str_replace(',', '', $decodedData['values'][39][7]); 
            $totalReceived = $totalReceived + $paidAmount;

            $outstandingBalance = (float) str_replace(',', '',  $decodedData['values'][39][8]);
            $totalBalance = $totalBalance + $outstandingBalance;

            $allSheetData[$sheet->sheet_no] = [
                'totalPrice' => $totalPrice,
                'registrationNumber' => $registrationNumber,
                'productCode' => $productCode,
                'paidAmount' => $paidAmount,
                'outstandingBalance' => $outstandingBalance
            ];          
        }
        
        return view('admin.sheets.index', ['sheets' => $allSheetData, 'totalReceived' => $totalReceived, 'totalBalance' => $totalBalance, 'totalBookings' => $totalBookings ]);

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
