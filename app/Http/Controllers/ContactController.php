<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;

class ContactController extends Controller
{
    public function storeApi(Request $request)
    {

        // Create a new contact record
        // Create a new contact record
        // Create a new contact record
        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'message' => $request->message,
            'inventory_number' => $request->has('inventory_number') ? $request->inventory_number : null, // Set to null or handle absence
            'inventory_name' => $request->has('inventory_name') ? $request->inventory_name : null, // Set to null or handle absence
            'floor' => $request->has('floor') ? $request->floor : null, // Set to null or handle absence
        ]);



        $formData = $request->all(); // Assuming $formData contains the form data
        $mail = new ContactUsMail($formData);
        $mail->from('example@gmail.com', 'Dayim Marketing');
        Mail::to('info@dayimmarketing.com')->send($mail);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Contact Us information sent'
        ], 200);
    }

    public function index()
    {
        return view('admin.contacts.index');
    }

    public function get_contacts(Request $request)
    {

        $result = Contact::orderBy('created_at', 'DESC');

        $aColumns = ['name', 'email', 'contact', 'message', 'floor', 'inventory_name', 'inventory_number'];

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

        $sKeywords = $request->get('sSearch');
        if ($sKeywords != "") {

            $result->Where(function ($query) use ($sKeywords) {
                $query->orWhere('name', 'LIKE', "%{$sKeywords}%");;
                $query->orWhere('email', 'LIKE', "%{$sKeywords}%");
                $query->orWhere('contact', 'LIKE', "%{$sKeywords}%");
                $query->orWhere('message', 'LIKE', "%{$sKeywords}%");
                $query->orWhere('floor', 'LIKE', "%{$sKeywords}%");
                $query->orWhere('inventory_name', 'LIKE', "%{$sKeywords}%");
                $query->orWhere('inventory_number', 'LIKE', "%{$sKeywords}%");
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

        foreach ($linksData as $aRow) {

            $checkbox = "<label class=\"mt-checkbox mt-checkbox-single mt-checkbox-outline\">
                             <input type=\"checkbox\" class=\"checkbox-index\" value=\"{$aRow->id}\">
                             <span></span>
                          </label>";

            $name = $aRow->name;
            $email = $aRow->email;
            $contact = $aRow->contact;
            $message = $aRow->message;
            $inventory_number = $aRow->inventory_number;
            $inventory_name = $aRow->inventory_name;
            $floor = $aRow->floor;

            $action = "<span class=\"dropdown\">
                          <button id=\"btnSearchDrop2\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\"
                          aria-expanded=\"false\" class=\"btn btn-info btn-sm dropdown-toggle\"><i class=\"la la-cog font-medium-1\"></i></button>
                          <span aria-labelledby=\"btnSearchDrop2\" class=\"dropdown-menu mt-1 dropdown-menu-right\">
                            <a href=\"#\" onClick=\"deleteContacts({$aRow->id})\"  class=\"dropdown-item font-small-3\"><i class=\"la la-repeat font-small-3\"></i> delete</a>
                          </span>
                        </span>
                        ";

            $output['aaData'][] = array(
                "DT_RowId" => "row_{$aRow->id}",
                @$name,
                @$email,
                @$contact,
                @$message,
                @$inventory_number,
                @$inventory_name,
                @$floor,
                @$action
            );

            $i++;
        }
        echo json_encode($output);
    }

    /**
     * Store a newly created resource in storage.
     */



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hotel = Contact::findOrFail($id);
        $hotel->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Contacts deleted successfully.'
        ], 200);
    }
}
