<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.payment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'pay_head' => 'required',
            'due_date' => 'required',
            'due_amount.*' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        for ($i = 0; $i < count($request->pay_head); $i++) {
            // Check if the payment record with the given ID exists
            $payment = Payment::find($request->id[$i]);

            if (!$payment) {
                // If the payment record doesn't exist, create a new instance
                $payment = new Payment();
            }

            // Populate the payment instance with data
            $payment->pay_head = $request->pay_head[$i];
            $payment->due_date = $request->due_date[$i];
            $payment->due_amount = $request->due_amount[$i];
            $payment->deposite_date = $request->deposite_date[$i];
            $payment->mode = $request->mode[$i];
            $payment->receipt = $request->receipt[$i];
            $payment->paid_amount = $request->paid_amount[$i];
            $payment->amount = $request->amount[$i];
            $payment->surchange = $request->surchange[$i];
            $payment->booking_id = $request->booking_id;

            // Save the payment record
            $payment->save();
        }

        return redirect()->route('bookings.index')->with('success', 'Payment plan has been Added successfully!');
    }

    public function store_proof(Request $request, $id)
    {
        $request->validate([
            'prof_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $payment = Payment::findOrFail($id);

        if ($request->hasFile('prof_image')) {
            $image = $request->file('prof_image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('proofs'), $imageName);
            $payment->prof_image = $imageName;
        }

        $payment->save();

        return redirect()->route('payments.index')->with('success', 'Proof uploaded successfully!');
    }

    public function getPayments(Request $request)
    {

        $userName = Auth::user()->name;
        if ($userName == "Admin") {
            $result = Payment::with('booking.user')->where('complete', '0')->orderBy('created_at', 'DESC');
        } else {
            $userId = Auth::id();
            $result = Payment::whereHas('booking', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('complete', '0')->orderBy('created_at', 'DESC');
        }

        $aColumns = ['name', 'pay_head', 'due_date', 'due_amount'];

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
                $query->orWhere('pay_head', 'LIKE', "%{$sKeywords}%");;
                $query->orWhere('due_date', 'LIKE', "%{$sKeywords}%");
                $query->orWhere('due_amount', 'LIKE', "%{$sKeywords}%");
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
            "aaData" => array(),
        );
        $i = 0;

        foreach ($linksData as $aRow) {

            $checkbox = "<label class=\"mt-checkbox mt-checkbox-single mt-checkbox-outline\">
                             <input type=\"checkbox\" class=\"checkbox-index\" value=\"{$aRow->id}\">
                             <span></span>
                          </label>";

            $hotel_id = $aRow->id;
            $name = $aRow->booking->user->name;
            $pay_head = $aRow->pay_head;
            $due_date = $aRow->due_date;
            $due_amount = $aRow->due_amount;

            $action = "<span class=\"dropdown\">
                          <button id=\"btnSearchDrop2\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\"
                          aria-expanded=\"false\" class=\"btn btn-info btn-sm dropdown-toggle\"><i class=\"la la-cog font-medium-1\"></i></button>
                          <span aria-labelledby=\"btnSearchDrop2\" class=\"dropdown-menu mt-1 dropdown-menu-right\">
                            <a href=\"add_payment/{$aRow->id}\" class=\"dropdown-item font-small-3\"><i class=\"la la-barcode font-small-3\"></i> Add Payment</a>
                          </span>
                        </span>
                        ";

            $output['aaData'][] = array(
                "DT_RowId" => "row_{$aRow->id}",
                @$name,
                @$pay_head,
                @$due_date,
                @$due_amount,
                @$action,
            );

            $i++;
        }
        echo json_encode($output);
    }

    public function add_payment(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        return view('admin.payment.create', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Payment = Payment::findOrFail($id);
        $Payment->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment record deleted successfully.',
        ], 200)->header('Content-Type', 'application/json')->header('X-Requested-With', 'XMLHttpRequest');

    }
}
