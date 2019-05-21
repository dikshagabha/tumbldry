<?php

namespace App\Http\Controllers\Api\Runner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Repositories\Runner\PickupPickupRepository;

class PickupController extends Controller
{
    
	protected $user;

    /**
     * Adds the Middleware to chekc whether the user is logged in or not
     */
    public function __construct()
    {
        // check the user is logged in or not
        $this->middleware('jwtcustom');
        // if the user is logged in then fetches the details of the user
        $this->middleware(function($request, $next) {
            $this->user = JWTAuth::parseToken()->authenticate();
            return $next($request);
        });
    }

    public function getPickupJobs(Request $request)
    {
    	$response = PickupPickupRepository::getPickupJobs($request, $this->user);
        $http_status = $response['http_status'];
        unset($response['http_status']);
        return response()->json($response, $http_status);
    }

    public function getDeliveryJobs(Request $request)
    {
        $response = PickupPickupRepository::getDeliveryJobs($request, $this->user);
        $http_status = $response['http_status'];
        unset($response['http_status']);
        return response()->json($response, $http_status);
    }

    public function getPickupDetails(Request $request)
    {
        $id = $request->input('id');
        $response = PickupPickupRepository::getPickupDetails($request, $this->user, $id);
        $http_status = $response['http_status'];
        unset($response['http_status']);
        return response()->json($response, $http_status);
    }

    public function getOrderDetails(Request $request)
    {
        $id = $request->input('id');
        $response = PickupPickupRepository::getOrderDetails($request, $this->user, $id);
        $http_status = $response['http_status'];
        unset($response['http_status']);
        return response()->json($response, $http_status);
    }

    public function getLastOrderDetails(Request $request)
    {
        $id = $request->input('id');
        $response = PickupPickupRepository::getLastOrderDetails($request, $this->user, $id);
        $http_status = $response['http_status'];
        unset($response['http_status']);
        return response()->json($response, $http_status);
    }

    public function cancelRequest(Request $request)
    {
        $id = $request->input('id');
        $response = PickupPickupRepository::cancelRequest($request, $this->user, $id);
        $http_status = $response['http_status'];
        unset($response['http_status']);
        return response()->json($response, $http_status);
    }
}
