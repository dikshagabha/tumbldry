<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
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
    //protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout()
    {
        Auth::Logout();

        return redirect()->route('login');
    }

    protected function redirectTo( ) {
        if (Auth::check() && Auth::user()->role == 1) {
       
            return '/admin/dashboard';
        }
    }
    protected function credentials(Request $request)
    {
        //dd($request->only($this->username(), 'password'));
        $arr = $request->only($this->username(), 'password');
        $arr['role'] = 1;
        //$cred = array_push($arr, ['role'=>1]);
        //dd($arr);
        return $arr;
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->role==1) {
            return redirect()->intended('dashboard');
        }
    }
}
