<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Customer\HomeRepository;
use JWTAuth;
use App\Requests\Customer\Auth\UpdateRequest;
use App\User;
use App\Model\{
    Address
};

use App\Http\Requests\Customer\Auth\AddressRequest;

class HomeController extends Controller
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

    public function update(UpdateRequest $request)
    {
      $address = $request->input('address');
      $response = HomeRepository::update($request, $this->user->id, null ,$address);
      
      $http_status = $response['http_status'];
      unset($response['http_status']);
      
      return response()->json($response, $http_status);
    }

    public function getcustomeraddresses()
    {
      $address = Address::where('user_id', $this->user->id)->get();

      if ($address) {
          return response()->json(['message'=>'Address Found.', 'data'=>$address], 200);
      }
      return response()->json(['message'=>'Address Not Found.'], 400);
    }
    public function saveAddress(AddressRequest $request)
    {
      $data = $request->only('address', 'state', 'city', 'pin', 'latitude', 'longitude');
      $data['user_id']=$this->user->id;
      $address = Address::create($data);

      if ($address) {
          return response()->json(['message'=>'Address Saved.', 'data'=>$address], 200);
      }
      return response()->json(['message'=>'Address Not Saved.'], 400);
    }
}
