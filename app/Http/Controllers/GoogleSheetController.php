<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\GoogleSheetsServices;
use App\Models\UserSheet;
use PDF;
use Illuminate\Support\Facades\Auth;

class GoogleSheetController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $sheets = UserSheet::where('user_id', $user)->get();
        
        $allSheetData = []; // Initialize an array to hold the data of all sheets
        $totalBookings = 0;
        $totalReceived = 0;
        $totalBalance = 0;
        // dd($sheets);
        
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

        return view('admin.sheets.index', ['sheets' => $allSheetData, 'totalReceived' => $totalReceived, 'totalBalance' => $totalBalance, 'totalBookings' => $totalBookings]);
    }

    public function get_sheets(Request $request)
    {
        $user = Auth::user()->id;
        $result = UserSheet::where('user_id', $user)->orderBy('created_at', 'DESC');
    
        $aColumns = ['registrationNumber', 'productCode', 'totalPrice', 'paidAmount', 'outstandingBalance'];
    
        $iStart = $request->get('iDisplayStart');
        $iPageSize = $request->get('iDisplayLength');
        $order = 'created_at';
        $sort = ' DESC';
    
        if ($request->get('iSortCol_0')) {

            $sOrder = "ORDER BY  ";

            for ($i = 0; $i < intval($request->get('iSortingCols')); $i++) {
                if ($request->get('bSortable_' . intval($request->get('iSortCol_' . $i))) == "true") {
                    $sOrder .= $aColumns[intval($request->get('iSortCol_' . $i))] . " " . $request->get('sSortDir_' . $i) . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = " id ASC";
            }

            $OrderArray = explode(' ', $sOrder);
            $order = trim($OrderArray[3]);
            $sort = trim($OrderArray[4]);
        }
    
        // Search functionality
        $sKeywords = $request->get('sSearch');
        if ($sKeywords != "") {
            $result = $result->where(function ($query) use ($sKeywords) {
                $query->orWhere('registrationNumber', 'LIKE', "%{$sKeywords}%")
                    ->orWhere('productCode', 'LIKE', "%{$sKeywords}%")
                    ->orWhere('totalPrice', 'LIKE', "%{$sKeywords}%")
                    ->orWhere('paidAmount', 'LIKE', "%{$sKeywords}%")
                    ->orWhere('outstandingBalance', 'LIKE', "%{$sKeywords}%");
            });
        }
        for ($i = 0; $i < count($aColumns); $i++) {
            $request->get('sSearch_' . $i);
            if ($request->get('bSearchable_' . $i) == "true" && $request->get('sSearch_' . $i) != '') {
                $result->orWhere($aColumns[$i], 'LIKE', "%" . $request->orWhere('sSearch_' . $i) . "%");
            }
        }

        $iFilteredTotal = $result->count();

        if ($iStart != null && $iPageSize != '-1') {
            $result->skip($iStart)->take($iPageSize);
        }

        $result->orderBy($order, trim($sort));
        $result->limit($request->get('iDisplayLength'));
        $linksData = $result->get();

        $iTotal = $iFilteredTotal;
        $output = array(
            "sEcho" => intval($request->get('sEcho')),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );
        $i = 0;

        $totalReceived = 0;
        $totalBalance = 0;
    
        foreach ($linksData as $aRow) {
            $data = (new GoogleSheetsServices($aRow->sheet_no))->readSheets();
            $decodedData = json_decode(json_encode($data), true);
    
            $totalPrice = $decodedData['values'][4][2];
            $registrationNumber = $decodedData['values'][4][4];
            $productCode = $decodedData['values'][5][7];
            $paidAmount = (float) str_replace(',', '', $decodedData['values'][39][7]);
            $totalReceived += $paidAmount;
    
            $outstandingBalance = (float) str_replace(',', '', $decodedData['values'][39][8]);
            $totalBalance += $outstandingBalance;
    
            $action = "<span class=\"dropdown\">
                          <button id=\"btnSearchDrop2\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\"
                          aria-expanded=\"false\" class=\"btn btn-info btn-sm dropdown-toggle\"><i class=\"la la-cog font-medium-1\"></i></button>
                          <span aria-labelledby=\"btnSearchDrop2\" class=\"dropdown-menu mt-1 dropdown-menu-right\">
                            <a href=\"sheet/{$aRow->sheet_no}\" class=\"dropdown-item font-small-3\"><i class=\"la la-barcode font-small-3\"></i> View Statement</a>
                          </span>
                        </span>";
    
            $output['aaData'][] = [
                "DT_RowId" => "row_{$aRow->id}",
                $registrationNumber,
                $productCode,
                $totalPrice,
                $paidAmount,
                $outstandingBalance,
                $action,
            ];
        }
    
        return response()->json($output);
    }

    public function single($id)
    {
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
