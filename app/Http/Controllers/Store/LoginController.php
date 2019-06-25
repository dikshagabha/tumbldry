<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Http\Requests\Store\LoginRequest;
use App\Repositories\CommonRepository;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
	public function __construct(){

	}
    public function getLogin(Request $Request){

    	$titlePage  = "Login";

    	// if (Auth::check()) {
    	// 	return redirect()->route('store.home');
    	// }
    	return view('store.auth.login', compact('titlePage'));
    }

    public function postLogin(LoginRequest $Request){
    	$credentials = $Request->only('phone_number', 'password');
        $credentials['role'] = 3;
        $credentials['status'] = 1;
        
    	if (Auth::attempt($credentials)) 
        {
    		return response()->json(["message"=>"User Authenicated", "redirectTo"=>route('store.home')], 200);
    	}

    	return response()->json(["message"=>"User Not Authenicated"], 400);

    }

    public function logout(Request $Request){
    	Auth::Logout();

        return redirect()->route('store.login');
    }

    public function forgetPassword(Request $Request){

        $titlePage  = "Forget Password";
        return view('store.auth.forget-password', compact('titlePage'));
    }

    public function postforgetPassword(Request $Request){

        $Request->validate([ 'phone_number' => ['bail', 'required', 'numeric', 'digits_between:8,15',
                        Rule::exists('users')->where(function($q) {
                            $q->where('role', 3)->where(['status'=> 1, 'deleted_at'=>null]);
                        })
                    ]
                ]);
        $pswd=CommonRepository::random_str();

        $user = User::where('phone_number', $Request->input('phone_number'))->update(['password'=>bcrypt($pswd)]);

        $data = 'Hello, Use '.$pswd.' as your password to login.';

        CommonRepository::sendmessage($Request->input('phone_number'), $data);

        return response()->json(["message"=>"Password sent to phone.", "redirectTo"=>route('store.home')], 200);
    }


}
