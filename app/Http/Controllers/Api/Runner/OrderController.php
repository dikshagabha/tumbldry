<?php

namespace App\Http\Controllers\Api\Runner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Runner\OrderRepository;


use App\Repositories\CommonRepository;
use JWTAuth;
use Carbon\Carbon;
use App\Model\Otp;


class OrderController extends Controller
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

    public function services(Request $request)
    {
        $response = OrderRepository::services($request, $this->user);
        echo $request->input('callback')."(".json_encode($response).")";
        // $http_status = $response['http_status'];
        // unset($response['http_status']);
        // return response()->json($response, $http_status);
    }

    public function laundaryAddons(Request $request)
    {
        $response = OrderRepository::addons($request, $this->user, 2);
        echo $request->input('callback')."(".json_encode($response).")";
        // $http_status = $response['http_status'];
        // unset($response['http_status']);
        // return response()->json($response, $http_status);
    }

    public function dryCleanAddons(Request $request)
    {
        $response = OrderRepository::addons($request, $this->user, 1);
        echo $request->input('callback')."(".json_encode($response).")";
        // $http_status = $response['http_status'];
        // unset($response['http_status']);
        // return response()->json($response, $http_status);
    }

    public function servicePrice(Request $request)
    {
        $request->validate(['service_id'=>'bail|required|numeric',
                            'item'=>'bail|required|string']);

        $response = OrderRepository::servicePrice($request, $this->user);
        echo $request->input('callback')."(".json_encode($response).")";
        // $http_status = $response['http_status'];
        // unset($response['http_status']);
        // return response()->json($response, $http_status);
    }

    public function serviceItems(Request $request)
    {
        $request->validate(['service_id'=>'bail|required|numeric']);

        $response = OrderRepository::serviceItem($request, $this->user);
        echo $request->input('callback')."(".json_encode($response).")";
        // $http_status = $response['http_status'];
        // unset($response['http_status']);
        // return response()->json($response, $http_status);
    }



}
