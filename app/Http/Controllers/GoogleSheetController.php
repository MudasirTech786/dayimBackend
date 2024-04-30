<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\GoogleSheetsServices;

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
}
