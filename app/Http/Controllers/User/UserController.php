<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.view');
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'cnic' => 'required|string|unique:users,cnic',
            'gender' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string|max:255',
            'active' => 'nullable|boolean',
            'password' => 'required|string|min:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3000', // Validation for image upload
            // 'sheet_no' => 'required|string|max:255'
        ];

        // Create a validator
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Creating the user
        $user = new User($request->only('name', 'email', 'cnic', 'gender', 'occupation', 'phone', 'address', 'active'));
        $user->password = Hash::make($request->password);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Unique file name
            $image->move(public_path('uploads'), $imageName);
            $user->image = $imageName;
        }

        $user->save(); // Save the user first

        // Creating and saving user sheet
        $userSheet = new UserSheet([
            'sheet_no' => $request->sheet_no,
            'inventory_name' => $request->inventory_name,
            'form_no' => $request->form_no
        ]);
        $user->sheets()->save($userSheet); // Associate and save user sheet

        // Assign roles, if role assignment is part of the request
        if ($request->filled('roles')) {
            $roles = $request->input('roles');
            $user->assignRole($roles); // Assuming you are using Spatie Permission Package
        }

        return redirect()->route('users.index')->with('success', 'User has been Added successfully!');
    }

    public function storeUserApi(Request $request)
    {
        // Validation rules for API
        $rules = [
            'name' => 'nullable|string|max:255',
            'cnic' => 'required|string|unique:users,cnic',
            'gender' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string|max:255',
            'active' => 'nullable|boolean',
            'password' => 'required|string|min:8',
            'sheet_no' => 'nullable|string|max:255',
            'inventory_name' => 'nullable|string|max:255',
            'form_no' => 'nullable|string|max:255',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422); // Unprocessable Entity
        }

        try {
            // Start transaction
            DB::beginTransaction();

            // Creating the user
            $user = new User($request->only('name', 'email', 'cnic', 'gender', 'occupation', 'phone', 'address', 'active'));
            $user->password = Hash::make($request->password);
            $user->save(); // Save the user

            // Creating and saving user sheet
            $userSheet = new UserSheet([
                'sheet_no' => $request->sheet_no,
                'inventory_name' => $request->inventory_name,
                'form_no' => $request->form_no
            ]);
            $user->sheets()->save($userSheet); // Associate and save user sheet

            // Assign roles, if role assignment is part of the request
            if ($request->filled('roles')) {
                $roles = $request->input('roles');
                $user->assignRole($roles); // Assuming you are using Spatie Permission Package
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'User has been added successfully!',
                'user' => $user
            ], 200); // Created

        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();

            // Return error response
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while adding the user!',
                'error' => $e->getMessage()
            ], 500); // Internal Server Error
        }
    }


    public function login(Request $request)
{
    // Validate incoming request
    $request->validate([
        'cnic' => 'required|string',
        'password' => 'required|string',
    ]);

    try {
        // Check if the user exists and is active
        $user = User::where('cnic', $request->cnic)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404); // Not Found
        }

        // Credentials from request
        $credentials = $request->only('cnic', 'password');

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Generate access token for the authenticated user
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ], 200); // OK
        } else {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401); // Unauthorized
        }
    } catch (\Exception $e) {
        // Catch any exceptions and return an error response
        return response()->json([
            'message' => 'An error occurred during login',
            'error' => $e->getMessage()
        ], 500); // Internal Server Error
    }
}


    public function checkCredentias(Request $request)
    {
        $payload = $request->validate([
            'cnic' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $user = User::where('cnic', $request->cnic)->first();
            if ($user) {
                // * Check password
                if (!Hash::check($payload["password"], $user->password)) {
                    return response()->json(["message" => "Invalid credentials."], 401);
                }
                return response()->json(["message" => "Loggedin succssfully!"], 200);
            }
            return response()->json(["message" => "No account found with these credentials."], 401);
        } catch (\Exception $err) {
            Log::info("user_register_err =>" . $err->getMessage());
            return response()->json(["message" => "Something went wrong!"], 500);
        }
    }

    public function get_users(Request $request)
    {

        $result = User::where('name', '!=', 'Admin')->orderBy('created_at', 'DESC');

        $aColumns = ['name', 'email', 'cnic', 'phone'];

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
                $query->orWhere('cnic', 'LIKE', "%{$sKeywords}%");
                $query->orWhere('phone', 'LIKE', "%{$sKeywords}%");
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
            $name = $aRow->name;
            $email = $aRow->email;
            $id_card = $aRow->cnic;
            $phone = $aRow->phone;
            $designation = $aRow->occupation;
            $role = $aRow->getRoleNames();
            $address = $aRow->address;

            $action = "<span class=\"dropdown\">
                          <button id=\"btnSearchDrop2\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\"
                          aria-expanded=\"false\" class=\"btn btn-info btn-sm dropdown-toggle\"><i class=\"la la-cog font-medium-1\"></i></button>
                          <span aria-labelledby=\"btnSearchDrop2\" class=\"dropdown-menu mt-1 dropdown-menu-right\">
                          <a href=\"" . route('sheet.user_sheets', ['id' => $aRow->id]) . "\" class=\"dropdown-item font-small-3\"><i class=\"la la-barcode font-small-3\"></i>view statements</a>
                          <a href=\"users/{$aRow->id}/edit\" class=\"dropdown-item font-small-3\"><i class=\"la la-barcode font-small-3\"></i> edit</a>  
                          <a href=\"#\" onClick=\"deleteUser({$aRow->id})\"  class=\"dropdown-item font-small-3\"><i class=\"la la-repeat font-small-3\"></i> delete</a>
                          </span>
                        </span>
                        ";

            $output['aaData'][] = array(
                "DT_RowId" => "row_{$aRow->id}",
                @$name,
                @$email,
                @$id_card,
                @$designation,
                @$role,
                @$action,
            );

            $i++;
        }
        echo json_encode($output);
    }

    public function edit($id)
    {
        $currentUser = Auth::user();
        $user = User::with(['roles', 'sheets'])->findOrFail($id);
        $users = User::all();
        $roles = Role::pluck('name', 'name')->all();
        $currentRole = $currentUser->roles->first()->name ?? null;
        return view('admin.user.edit', compact('user', 'users', 'roles', 'currentRole'));
    }

    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $rules = [
            'name' => 'required',
            'cnic' => 'required|unique:users,cnic,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:3000',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->cnic = $request->cnic;
        $user->gender = $request->gender;
        $user->occupation = $request->occupation;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->active = $request->activeUser;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $user->image = $imageName;
        }

        $user->save();

        // Handle roles update
        $roles = $request->input('roles');
        $user->roles()->detach();
        $user->assignRole($roles);

        // Update user sheets
        // $user->sheets()->delete(); // Remove all existing sheets first
        $user->save();
        // foreach ($request->input('sheet_no', []) as $sheetNo) {
        //     if (!empty($sheetNo)) {
        //         $user->sheets()->create(['sheet_no' => $sheetNo]);
        //     }
        // }
        if ($request->sheet_no) {
            foreach ($request->sheet_no as $key => $sheet_noData) {
                $sheetId = $request->sheet_ids[$key] ?? null; // Existing cost ID

                $cost = UserSheet::findOrNew($sheetId);

                // Update the cost attributes
                // $cost->item_id = $transport->id;
                $cost->user_id = $id;
                $cost->sheet_no = $request->sheet_no[$key];
                $cost->inventory_name = $request->inventory_name[$key];
                $cost->form_no = $request->form_no[$key];
                $cost->dealer = $request->dealer[$key];
                // Save the cost instance
                $cost->save();
            }
            return redirect()->route('users.index')->with('success', 'User has been updated successfully!');
        }
        return redirect()->route('home')->with('success', 'User has been updated successfully!');
    }

    public function destroy($id)
    {
        $hotel = User::findOrFail($id);
        $imagePath = public_path('uploads');
        $imageFileName = $hotel->image; // Assuming the image file name is stored in the 'image' column
        if ($imageFileName && file_exists($imagePath . '/' . $imageFileName)) {
            unlink($imagePath . '/' . $imageFileName);
        }
        $hotel->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully.',
        ], 200);

        return view('website.user.dashboard');
    }

    public function simple_profile()
    {
        return view('website.user.simple-profile.index');
    }

    public function detail_profile()
    {
        $user = Auth::user();

        $professional_skills = json_decode($user->professional_skills);
        if (empty(json_decode($user->interpersonal_skills))) {
            $interpersonal_skills = array();
        } else {
            $interpersonal_skills = json_decode($user->interpersonal_skills);
        }

        if (empty(json_decode($user->professional_skills))) {
            $professional_skills = array();
        } else {
            $professional_skills = json_decode($user->professional_skills);
        }

        $careerBackgrounds = $user->careerBackgrounds;
        $personalizedBackgrounds = $user->personalizedBackgrounds;
        $qualifications = $user->qualifications;

        return view('website.user.detail-profile.index', compact('user', 'careerBackgrounds', 'professional_skills', 'interpersonal_skills', 'personalizedBackgrounds', 'qualifications'));
    }

    public function edit_simple_profile()
    {
        $user = Auth::user();

        return view('website.user.simple-profile.edit', compact('user'));
    }

    public function simple_profile_settings()
    {
        $user = Auth::user();

        return view('website.user.simple-profile.account-setting', compact('user'));
    }

    public function store_detail_profile(Request $request)
    {
        return $request;
    }

    public function update_simple_profile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->date_of_birth = $request->date_of_birth;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->location = $request->location;

        if ($request->has('image')) {
            if (isset($user->image)) {
                @unlink('storage/user_image/' . $user->image);
            }

            $image = $request->file('image');
            $user_image = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/user_image');
            $image->move($destinationPath, $user_image);
            $user->image = $user_image;
        }

        $user->save();

        return redirect()->route('user.simple.profile')->with('success', "Simple Profile Updated Successfully");
    }

    public function resume()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);

        $professionalSkills = json_decode($user->professional_skills);
        $profSkills = explode(",", $professionalSkills[0]);
        $interpersonalSkills = json_decode($user->interpersonal_skills);
        $intpersonalSkills = explode(",", $interpersonalSkills[0]);

        return view('website.user.resume.index', compact('profSkills', 'intpersonalSkills'));
    }

    public function update_profile_settings(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $hashedPassword = $user->password;

        if (isset($request->password)) {
            if ($this->checkPassword($request->current_password, $hashedPassword) == true) {
                $user->password = Hash::make($request->password);
            } else {
                return redirect()->back()->with('error', "Your current password is incorrect");
            }
        }

        if ($request->is_active == "on") {
            $user->is_active = 1;
        } else {
            $user->is_active = 0;
        }

        $user->save();

        return redirect()->back()->with('success', "Your settings has been updated Successfully");
    }

    public function checkPassword($current_password, $hashedPassword)
    {
        if (Hash::check($current_password, $hashedPassword)) {
            return true;
        } else {
            return false;
        }
    }

    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('change-password')->with('status', 'Password changed successfully');
    }
}
