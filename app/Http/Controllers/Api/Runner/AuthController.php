<?php

namespace App\Http\Controllers\Api\Runner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Runner\{
    HomeRepository
};

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

    	//dd($response);

        echo $request->input('callback')."(".json_encode($response).")";
        // dd($request->all());
        // $http_status = $response['http_status'];
        // unset($response['http_status']);

        // dd($response);
         return response()->json($response, 200);
    }

    public function register(RegisterRequest $request)
    {
    	
    	$response = HomeRepository::store($request, null);
        
        echo $request->input('callback')."(".json_encode($response).")";
        // $http_status = $response['http_status'];

        // unset($response['http_status']);
        // return response()->json($response, $http_status);
    }

    public function getPickupJobs(RegisterRequest $request)
    {
    	
    	// $response = HomeRepository::store($request, null);
     //    echo $request->input('callback')."(".json_encode($response).")";   
        
        // $http_status = $response['http_status'];
        // unset($response['http_status']);
        // return response()->json($response, $http_status);
    }

    public function sendOtp(Request $request)
    {   
        $request->validate(['phone_number'=>'bail|required|numeric|min:0000000000|max:9999999999']);

        $response = HomeRepository::sendOtp($request);
        
        echo $request->input('callback')."(".json_encode($response).")";   
        // $http_status = $response['http_status'];
        // unset($response['http_status']);
        //return response()->json($response, $http_status);
    }

    public function verifyotp(Request $request)
    {
        $request->validate(['phone_number'=>'bail|required|numeric|min:0000000000|max:9999999999']);

        $response = HomeRepository::verifyotp($request);
        $http_status = $response['http_status'];
        unset($response['http_status']);
        return response()->json($response, $http_status);
    }
}
