<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Customer\{
    HomeRepository
};
use App\Model\Service;
use App\Http\Requests\Runner\Auth\LoginRequest;
use App\Http\Requests\Runner\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function login(Request $request)
    {   
    	header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');
        
        $request->validate([
            'phone_number'=>'bail|required|numeric',
            'password'=>'required'
        ]);
    	
        $response = HomeRepository::login($request);
        $http_status = $response['http_status'];
        return response()->json($response, $http_status);
    }

    public function register(RegisterRequest $request)
    {
    	
    	$response = HomeRepository::store($request, null);
        $http_status = $response['http_status'];
        return response()->json($response, $http_status);
    }
    public function sendOtp(Request $request)
    {   
        $request->validate(['phone_number'=>'bail|required|numeric|min:0000000000|max:9999999999']);

        $response = HomeRepository::sendOtp($request);
        $http_status = $response['http_status'];
        return response()->json($response, $http_status);  
    }

    public function verifyotp(Request $request)
    {
        $request->validate(['phone_number'=>'bail|required|numeric|min:0000000000|max:9999999999']);

        $response = HomeRepository::verifyotp($request);
        $http_status = $response['http_status'];
        return response()->json($response, $http_status);
    }

    public function services(Request $request)
    {
        $services = Service::where('status', 1)->get();
        $addon = $services->where('type', 2);
        $srvice = $services->where('type', 1);
        return response()->json(['services'=>$srvice, 'addons'=>$addon, 'message'=>'Success'], 200);
    }
}
