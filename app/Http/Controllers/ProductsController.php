<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ZindagiProduct;
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


    public function living_index()
    {
        return view('admin.products.living_index');
    }


    public function zindagi_index()
    {
        return view('admin.products.zindagi_index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dealers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Dealer');
        })->get();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Customer');
        })->get(); // Fetch all users from the database
        return view('admin.products.create', compact('users', 'dealers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->input());

        if ($request->input('name') === 'Dayim Zindagi') {
            // -------------------------
            // Save in zindagi_products
            // -------------------------
            $request->validate([
                'category' => 'required|string',
                'dz_type' => 'required|string',
                'subtype' => 'nullable|string',
                'size' => 'required|numeric',
            ]);

            $product = new ZindagiProduct();
            $product->name = $request->input('name');
            $product->dealer = $request->input('dealer');
            $product->sold = $request->input('sold');
            $product->purchased_by = $request->input('purchased_by');
            $product->category = $request->input('category');
            $product->dz_type = $request->input('dz_type');
            $product->subtype = $request->input('subtype');
            $product->size = $request->input('size');
            $product->floor = $request->input('floor');
            $product->number = $request->input('number');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads'), $imageName);
                $product->image = $imageName;
            }

            $product->save();
            return redirect()->route('products.zindagi_index')->with('success', 'Product has been Added successfully!');
        } else {

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
        $dealers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Dealer');
        })->get();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Customer');
        })->get();
        return view('admin.products.edit', compact('dealers', 'product', 'users'));
    }

    public function living_edit(string $id)
    {
        $product = Product::findOrFail($id);
        $dealers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Dealer');
        })->get();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Customer');
        })->get();
        return view('admin.products.living_edit', compact('dealers', 'product', 'users'));
    }


    public function zindagi_edit(string $id)
    {
        $product = ZindagiProduct::findOrFail($id);
        $dealers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Dealer');
        })->get();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Customer');
        })->get();
        return view('admin.products.zindagi_edit', compact('dealers', 'product', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'sold' => 'required|string',
            'size' => 'required|string',
            'floor' => 'required|string',
            'number' => 'required|numeric',
            'type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming image is uploaded
        ]);

        // Create new Product instance
        $product = Product::findOrFail($id);
        $product->name = "DSA";
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

    public function living_update(Request $request, string $id)
    {
        $request->validate([
            'sold' => 'required|string',
            'size' => 'required|string',
            'floor' => 'required|string',
            'number' => 'required|numeric',
            'type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming image is uploaded
        ]);

        // Create new Product instance
        $product = Product::findOrFail($id);
        $product->name = "Dayim Living";
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

        return redirect()->route('products.living_index')->with('success', 'Product has been Updated successfully!');
    }

    public function zindagi_update(Request $request, string $id)
    {
        $request->validate([
            'category' => 'required|string',
            'dz_type' => 'required|string',
            'subtype' => 'nullable|string',
            'size' => 'required|numeric',
        ]);

        $product = ZindagiProduct::findOrFail($id);
        $product->name = "Dayim Zindagi";
        $product->dealer = $request->input('dealer');
        $product->sold = $request->input('sold');
        $product->purchased_by = $request->input('purchased_by');
        $product->category = $request->input('category');
        $product->dz_type = $request->input('dz_type');
        $product->subtype = $request->input('subtype');
        $product->size = $request->input('size');
        $product->floor = $request->input('floor');
        $product->number = $request->input('number');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('products.zindagi_index')->with('success', 'Zindagi Product updated successfully!');
    }


    public function get_products(Request $request)
    {

        $result = Product::where('name', 'DSA')->orderBy('created_at', 'DESC');

        $aColumns = ['floor', 'type', 'size', 'sold'];

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
                $query->orWhere('size', 'LIKE', "%{$sKeywords}%");
                $query->orWhere('sold', 'LIKE', "%{$sKeywords}%");
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
            $size = $aRow->size;
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
                @$size,
                @$sold,
                @$action,
            );

            $i++;
        }
        echo json_encode($output);
    }

    public function get_living_products(Request $request)
    {

        $result = Product::where('name', 'Dayim Living')->orderBy('created_at', 'DESC');

        $aColumns = ['floor', 'type', 'sold', 'size'];

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
                $query->orWhere('sold', 'LIKE', "%{$sKeywords}%");
                $query->orWhere('size', 'LIKE', "%{$sKeywords}%");
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
            $sold = $aRow->sold;
            $size = $aRow->size;

            $action = "<span class=\"dropdown\">
                          <button id=\"btnSearchDrop2\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\"
                          aria-expanded=\"false\" class=\"btn btn-info btn-sm dropdown-toggle\"><i class=\"la la-cog font-medium-1\"></i></button>
                          <span aria-labelledby=\"btnSearchDrop2\" class=\"dropdown-menu mt-1 dropdown-menu-right\">
                            <a href=\"product/{$aRow->id}/edit\" class=\"dropdown-item font-small-3\"><i class=\"la la-barcode font-small-3\"></i> edit</a>
                            <a href=\"#\" onClick=\"deleteProduct({$aRow->id})\"  class=\"dropdown-item font-small-3\"><i class=\"la la-repeat font-small-3\"></i> delete</a>
                          </span>
                        </span>
                        ";

            $output['aaData'][] = array(
                "DT_RowId" => "row_{$aRow->id}",
                @$floor,
                @$type,
                @$size,
                @$sold,
                @$action,
            );

            $i++;
        }
        echo json_encode($output);
    }

    public function get_zindagi_products(Request $request)
    {

        $result = ZindagiProduct::where('name', 'Dayim Zindagi')->orderBy('created_at', 'DESC');

        $aColumns = ['floor', 'type', 'sold', 'size'];

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
                $query->orWhere('dz_type', 'LIKE', "%{$sKeywords}%");
                $query->orWhere('sold', 'LIKE', "%{$sKeywords}%");
                $query->orWhere('size', 'LIKE', "%{$sKeywords}%");
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
            $type = $aRow->dz_type . ' - ' . $aRow->subtype;
            $size = $aRow->size;
            $sold = $aRow->sold;

            $action = "<span class=\"dropdown\">
                          <button id=\"btnSearchDrop2\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\"
                          aria-expanded=\"false\" class=\"btn btn-info btn-sm dropdown-toggle\"><i class=\"la la-cog font-medium-1\"></i></button>
                          <span aria-labelledby=\"btnSearchDrop2\" class=\"dropdown-menu mt-1 dropdown-menu-right\">
                            <a href=\"zindagi_product/{$aRow->id}/edit\" class=\"dropdown-item font-small-3\"><i class=\"la la-barcode font-small-3\"></i> edit</a>
                            <a href=\"#\" onClick=\"deleteProduct({$aRow->id})\"  class=\"dropdown-item font-small-3\"><i class=\"la la-repeat font-small-3\"></i> delete</a>
                          </span>
                        </span>
                        ";

            $output['aaData'][] = array(
                "DT_RowId" => "row_{$aRow->id}",
                @$floor,
                @$type,
                @$size,
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
    
    
    public function zidagiapiIndex()
    {
        // Retrieve all products
        $products = ZindagiProduct::all();

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
    
    public function zindagi_destroy(string $id)
    {
        // Find the product by ID
        $product = ZindagiProduct::findOrFail($id);

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
