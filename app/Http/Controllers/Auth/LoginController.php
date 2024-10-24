<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/login');
    }


    // Override the username method to return the column name used for CNIC
    public function username()
    {
        return 'cnic';
    }

    // Override the login method to use CNIC for authentication
    public function login(Request $request)
    {
        $request->validate([
            'cnic' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('cnic', 'password');

        // Check if the user exists and is active
        $user = User::where('cnic', $request->cnic)->first();

        if ($user) {
            if ($user->active == 0) {
                return back()->withErrors(['cnic' => 'Your account is not activated. Please contact the administrator.'])->withInput($request->only('cnic'));
            }

            // Attempt to authenticate the user
            if (Auth::attempt($credentials)) {
                if ($user->hasRole('Admin')) {
                    return redirect()->intended('/home');
                } else {
                    return redirect()->intended('/sheet');
                }
            }
        }

        // Authentication failed
        return back()->withErrors(['cnic' => 'Invalid CNIC or password'])->withInput($request->only('cnic'));
    }
}
