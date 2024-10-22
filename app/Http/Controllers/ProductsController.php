<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.products.index');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // Fetch all users from the database
        return view('admin.products.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'sold' => 'required|string',
            'size' => 'required|string',
            'floor' => 'required|string',
            'number' => 'required|numeric',
            'type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming image is uploaded
        ]);

        // Create new Product instance
        $product = new Product();
        $product->name = $request->input('name');
        $product->dealer = $request->input('dealer');
        $product->sold = $request->input('sold');
        $product->purchased_by = $request->input('purchased_by');
        $product->title = $request->input('title');
        $product->size = $request->input('size');
        $product->floor = $request->input('floor');
        $product->number = $request->input('number');
        $product->type = $request->input('type');

        // Handle image upload (if provided)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $product->image = $imageName;
        }

        // Save the product
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product has been Added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $users = User::all();
        return view('admin.products.edit', compact('product', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'sold' => 'required|string',
            'size' => 'required|string',
            'floor' => 'required|string',
            'number' => 'required|numeric',
            'type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming image is uploaded
        ]);

        // Create new Product instance
        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->dealer = $request->input('dealer');
        $product->sold = $request->input('sold');
        $product->purchased_by = $request->input('purchased_by');
        $product->title = $request->input('title');
        $product->size = $request->input('size');
        $product->floor = $request->input('floor');
        $product->number = $request->input('number');
        $product->type = $request->input('type');

        // Handle image upload (if provided)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $product->image = $imageName;
        }

        // Save the product
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product has been Updated successfully!');
    }


    public function get_products(Request $request)
    {

        $result = Product::orderBy('created_at', 'DESC');

        $aColumns = ['floor' , 'type' , 'number' , 'sold'];

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
                $query->orWhere('floor', 'LIKE', "%{$sKeywords}%");
                $query->orWhere('type', 'LIKE', "%{$sKeywords}%");
                $query->orWhere('number', 'LIKE', "%{$sKeywords}%");;
                $query->orWhere('sold', 'LIKE', "%{$sKeywords}%");;
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
            $floor = $aRow->floor;
            $type = $aRow->type;
            $number = $aRow->number;
            $sold = $aRow->sold;

            $action = "<span class=\"dropdown\">
                          <button id=\"btnSearchDrop2\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\"
                          aria-expanded=\"false\" class=\"btn btn-info btn-sm dropdown-toggle\"><i class=\"la la-cog font-medium-1\"></i></button>
                          <span aria-labelledby=\"btnSearchDrop2\" class=\"dropdown-menu mt-1 dropdown-menu-right\">
                            <a href=\"products/{$aRow->id}/edit\" class=\"dropdown-item font-small-3\"><i class=\"la la-barcode font-small-3\"></i> edit</a>
                            <a href=\"#\" onClick=\"deleteProduct({$aRow->id})\"  class=\"dropdown-item font-small-3\"><i class=\"la la-repeat font-small-3\"></i> delete</a>
                          </span>
                        </span>
                        ";

            $output['aaData'][] = array(
                "DT_RowId" => "row_{$aRow->id}",
                @$floor,
                @$type,
                @$number,
                @$sold,
                @$action,
            );

            $i++;
        }
        echo json_encode($output);
    }


    public function apiIndex()
    {
        // Retrieve all products
        $products = Product::all();

        // Return a JSON response
        return response()->json($products, 200); // HTTP 200 OK
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Check if the product has an associated image
        if ($product->image) {
            // Define the path to the image
            $imagePath = public_path('uploads/' . $product->image);

            // Check if the file exists and delete it
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the image file
            }
        }

        // Delete the product
        $product->delete();

        // Return a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully.',
        ], 200);
    }
}
