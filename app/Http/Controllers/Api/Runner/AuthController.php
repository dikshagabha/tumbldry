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
    public function login(LoginRequest $request)
    {
	print_r($request->all());
    	$response = HomeRepository::login($request);

    	//dd($response);
        $http_status = $response['http_status'];
        unset($response['http_status']);
        return response()->json($response, $http_status);
    }

    public function register(RegisterRequest $request)
    {
    	
    	$response = HomeRepository::store($request, null);
        $http_status = $response['http_status'];
        unset($response['http_status']);
        return response()->json($response, $http_status);
    }

    public function getPickupJobs(RegisterRequest $request)
    {
    	
    	$response = HomeRepository::store($request, null);
        $http_status = $response['http_status'];
        unset($response['http_status']);
        return response()->json($response, $http_status);
    }
}
