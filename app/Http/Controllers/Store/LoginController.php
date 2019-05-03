<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Http\Requests\Store\LoginRequest;
class LoginController extends Controller
{
	public function __construct(){

	}
    public function getLogin(Request $Request){

    	$titlePage  = "Login";

    	if (Auth::check()) {
    		return redirect()->route('store.home');
    	}
    	return view('store.auth.login', compact('titlePage'));
    }

    public function postLogin(LoginRequest $Request){
    	
    	//$checked = ;
    	//dd($checked);

    	$credentials = $Request->only('email', 'password');
        $credentials['role'] = 3;

        //print_r(Auth::logout());die;
    	if (Auth::attempt($credentials, true)
    		) {
    			// $authUser =User::where($credentials)->first();
       //  		Auth::login($authUser, true);
    		 //$Request->session()->put('current_user',Auth::user());
    		// Session::put('initial_login', '1');
    		return response()->json(["message"=>"User Authenicated", "redirectTo"=>route('store.home')], 200);
    	}

    	return response()->json(["message"=>"User Not Authenicated"], 400);

    }

    public function logout(Request $Request){
    	Auth::Logout();

        return redirect()->route('store.login');
    }

}
