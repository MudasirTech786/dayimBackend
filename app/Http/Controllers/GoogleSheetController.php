<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\GoogleSheetsServices;

class GoogleSheetController extends Controller
{
    public function index(){
        $data  = (new GoogleSheetsServices())->readSheets();
        $decodedData = json_decode(json_encode($data), true);

        return view('admin.sheets.index', ['data' => $decodedData]);
    }
}