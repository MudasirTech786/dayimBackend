<?php

namespace App\Http\Controllers;

use App\Models\PaymentTypes;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class PaymentTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.payment_types.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function get_payment_types(Request $request)
    {

        $result = PaymentTypes::with(['user', 'product']) // Eager load relationships
            ->orderBy('created_at', 'DESC');

        $aColumns = ['user.name', 'user.cnic', 'product.name', 'cash', 'payment'];

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
            $order = trim($OrderArray[0]);
            $sort = trim($OrderArray[1]);
        }

        $sKeywords = $request->get('sSearch');
        if ($sKeywords != "") {

            $result->Where(function ($query) use ($sKeywords) {
                $query->orWhereHas('user', function ($query) use ($sKeywords) {
                    $query->where('name', 'LIKE', "%{$sKeywords}%");
                });
                $query->orWhereHas('user', function ($query) use ($sKeywords) {
                    $query->where('cnic', 'LIKE', "%{$sKeywords}%");
                });
                $query->orWhereHas('product', function ($query) use ($sKeywords) {
                    $query->where('name', 'LIKE', "%{$sKeywords}%");
                });
                $query->orWhere('cash', 'LIKE', "%{$sKeywords}%");
                $query->orWhere('payment', 'LIKE', "%{$sKeywords}%");
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

            $username = $aRow->user->name ?? '';
            $usercnic = $aRow->user->cnic ?? 'N/A';
            $productName = $aRow->product->name ?? 'N/A';
            $hotel_id = $aRow->id;
            $payment = $aRow->payment;
            $type = 'None';
            if ($payment == 'cash') {
                $type = "cash payment";
            } elseif ($payment == 'bank') {
                $type = 'bank payment';
            }


            $action = "<span class=\"dropdown\">
                          <button id=\"btnSearchDrop2\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\"
                          aria-expanded=\"false\" class=\"btn btn-info btn-sm dropdown-toggle\"><i class=\"la la-cog font-medium-1\"></i></button>
                          <span aria-labelledby=\"btnSearchDrop2\" class=\"dropdown-menu mt-1 dropdown-menu-right\">
                          <a href=\"" . route('payment.show', ['payment' => $aRow->id]) . "\" class=\"dropdown-item font-small-3\"><i class=\"la la-barcode font-small-3\"></i>view Payment</a>
                          <a href=\"#\" onClick=\"deleteProduct({$aRow->id})\"  class=\"dropdown-item font-small-3\"><i class=\"la la-repeat font-small-3\"></i> delete</a>
                          </span>
                        </span>
                        ";

            $output['aaData'][] = array(
                "DT_RowId" => "row_{$aRow->id}",
                @$username,
                @$usercnic,
                @$productName,
                @$type,
                @$action,
            );

            $i++;
        }
        Log::info($output); // Log the output for debugging
        echo json_encode($output);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'payment' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);
    
        try {
            // Start a transaction
            DB::beginTransaction();
    
            // Create new PaymentType
            $paymentType = new PaymentTypes();
            $paymentType->user_id = $request->user_id;
            $paymentType->product_id = $request->product_id;
            $paymentType->payment = $request->payment;
    
            // Handle image upload
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('payments', 'public'); // Store in public disk
                $paymentType->image = $path;
            }
    
            // Save the payment type record
            $paymentType->save();
    
            // Commit the transaction
            DB::commit();
    
            // Return success response
            return response()->json([
                'status' => 'success',
                'data' => $paymentType,
                'message' => 'Payment type created successfully!'
            ], 200); // Created
    
        } catch (\Exception $e) {
            // Rollback transaction if error occurs
            DB::rollBack();
    
            // Return error response
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while saving the payment type.',
                'error' => $e->getMessage()
            ], 500); // Internal Server Error
        }
    }
    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymentType = PaymentTypes::with(['user', 'product'])->findOrFail($id);
    
        // Pass the payment type, user name, and product name to the view
        return view('admin.payment_types.show', compact('paymentType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $paymentType = PaymentTypes::findOrFail($id);
        // $users = User::all();
        // $products = Product::all();
        // return view('admin.payment_types.edit', compact('paymentType', 'users', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'cash' => 'required|numeric',
            'payment' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update the PaymentType instance
        $paymentType = PaymentTypes::findOrFail($id);
        $paymentType->cash = $request->input('cash');
        $paymentType->payment = $request->input('payment');
        $paymentType->user_id = $request->input('user_id');
        $paymentType->product_id = $request->input('product_id');

        // Handle image upload (if provided)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $paymentType->image = $imageName;
        }

        // Save the changes
        $paymentType->save();

        return redirect()->route('payment_types.index')->with('success', 'Payment type has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paymentType = PaymentTypes::findOrFail($id);
    
        // Delete image if it exists
        if ($paymentType->image) {
            // Assuming $paymentType->image stores the filename like 'payments/image.jpg'
            $imagePath =  $paymentType->image;
            Storage::disk('public')->delete($imagePath);
        }
        $paymentType->delete();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Payment record deleted successfully.',
        ], 200)->header('Content-Type', 'application/json')->header('X-Requested-With', 'XMLHttpRequest');
    }
    

    /**
     * Retrieve all payment types for API.
     */
    public function apiIndex()
    {
        $paymentTypes = PaymentTypes::all();
        return response()->json($paymentTypes, 200);
    }
}
