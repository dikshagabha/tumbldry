<?php

namespace App\Http\Controllers\Api\Runner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Customer\HomeRepository;
use JWTAuth;
use App\Requests\Customer\Auth\RegisterRequest;
use App\User;

class CustomerController extends Controller
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

    public function store(RegisterRequest $request)
    {
        $response = HomeRepository::store($request, $this->user);
        //echo $request->input('callback')."(".json_encode($response).")";
        $http_status = $response['http_status'];
        //unset($response['http_status']);
        if($request->input('callback'))
        {
            echo $request->input('callback')."(".json_encode($response).")";
        }else{
            return response()->json($response, 200);
        }
    }

    public function orderDetails(Request $request, $id)
    {

        $response['order'] =  Order::where('id', $id)->with('items')->first();;
        $response['code'] = 1;
        $response['mes']= 'Success';

        if($request->input('callback'))
        {
            echo $request->input('callback')."(".json_encode($response).")";
        }else{
            return response()->json($response, 200);
        }
        //return response()->json($response, $http_status);
    }

    public function searchCustomer(Request $request)
    {
        $validatedData = $request->validate([
          'phone_number' => 'bail|required|numeric|min:2|max:9999999999',
          ]);


        $customer = User::where('role', 4)
                  ->where('phone_number', 'like', '%'.$request->input('phone_number').'%')->first();
        
        $response['code'] = 1;
        $response['message']= 'Success';
        $response['details']=['data'=>$customer];

        if ($customer) {
             if($request->input('callback'))
                {
                    echo $request->input('callback')."(".json_encode($response).")";
                    return;
                }else{
                    return response()->json($response, 200);
                }
        }
        $response['code'] = 2;
        $response['message']= 'Customer Not Found!!';
        $response['details']=['data'=>$customer];
        if($request->input('callback'))
        {
            echo $request->input('callback')."(".json_encode($response).")";
        }else{
            return response()->json($response, 400);
        }
        //return response()->json(["message"=>"Customer Not Found!!"], 400);
    }


}
