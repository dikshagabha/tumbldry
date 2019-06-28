<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Model\Location;
use App\Model\Service;
use App\Model\Address;
use App\Model\Order;
use App\Model\PickupRequest;
use App\User;

use App\Model\ServicePrice;

use App\Model\Items;

use App\Http\Requests\Admin\AddAddressRequest;

use App\Http\Requests\Customer\Auth\AddressRequest as sessionAddressRequest;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

     public $user;
    public function __construct()
    {
       $this->middleware(function($request, $next) {
              $this->user = Auth::user();
              return $next($request);
          });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
       $user = User::get();
       $service = Service::count();
       $timezone = $request->session()->get('user_timezone', 'Asia/Calcutta');
       $cities = Location::groupBy('city_name')->selectRaw('city_name')->orderBy('city_name', 'asc')->pluck('city_name', 'city_name');
        $pending = PickupRequest::where('store_id', null)->paginate(10);
        $cities['global']='Global';
        $stores = $user->where('role', 3)->pluck('name', 'id');

        $types = [1=>"Dry Clean", 2=>"Laundary", 3=>'Car Clean', 4=>'Shoe Clean', 5=>'Sofa Clean', 6=>'Home Clean'];
      
        return view('admin.dashboard', compact('user', 'service', 'cities', 'types', 'pending', 'timezone', 'stores'));
    }

    public function assignStore(Request $request, $id)
    {
      $pickup = PickupRequest::where('id', $id)->update($request->only('store_id'));
      if ($pickup) {
        return response()->json(["message"=>"Pickup Assigned"], 200);
      }
      return response()->json(["message"=>"Something went wrong."], 400);
    }

    public function getServices(Request $request)
    {
      $service = Service::where('form_type', $request->type)->pluck('name', 'id');
      return response()->json(["message"=>"Data Recieved", 'service'=>$service], 200);
    }

    public function getRate(Request $request)
    {
      
      $validatedData = $request->validate([
          'city' => 'bail|required|string',
          'service' => 'bail|required|numeric',
          ]);
      
      $prices = ServicePrice::where(['location'=>$request->input('city'), 
                                      'service_id'=>$request->input('service')])->paginate(5);
      
      
      $type = $request->input('type');
      
      $edit = $prices->count();

      if ($request->ajax()) 
      {
        return view("admin.rates-table", compact('type', 'prices', 'edit'));
      }
      return response()->json(["message"=>"Data Recieved", 'prices'=>view("admin.rates-table",
                            compact('type', 'prices'))->render()], 200);
    }

    public function editProfile()
    {
      $user=Auth::User();
      $address = $user->address()->first();
      return view('store.editProfile.index', compact('user', 'address'));
    }


      public function postEditProfile(Request $request)
      {
        $user=Auth::User()->update($request->only('name', 'store_name', 'phone_number'));
        //$address = $user->address()->first();
        return response()->json(["message"=>""], 200);
      }

      public function addAddress(Request $request)
      {
        //$locations = Location::get();
        return view('admin.addAddressForm');
        //return response()->json(['data'=>view('admin.test')->render()], 200);
      }

      public function postAddAddress(AddAddressRequest $request)
      {

        $add = Address::create($request->only('address', 'city', 'state', 'pin', 'landmark', 'latitude', 'longitude', 'location_id'));
        if ($add) {
          return response()->json(["message"=>"Address Added", 'address'=>$add, 'url'=>route('admin.editAddress', ["id"=>$add->id])], 200);
        }
        return response()->json(["message"=>"Something went wrong!"], 400);

      }

      public function editAddress(Request $request)
      {
        $id=$request->input('id');
        $locations = Location::get();
        $address = Address::where('id', $id)->first();
        return view('admin.editAddressForm', compact('locations', 'address'));
      }

      public function postEditAddress(AddAddressRequest $request)
      {
        $id=$request->input('id');
        $add = Address::where('id', $id)->update($request->only('address', 'city', 'state', 'pin', 'landmark', 'latitude', 'longitude', 'location_id'));
        $add = Address::where('id', $id)->first();
        if ($add) {
          return response()->json(["message"=>"Address Edited", 'address'=>$add, 'url'=>route('admin.editAddress', ["id"=>$add->id])], 200);
        }
        return response()->json(["message"=>"Something went wrong!"], 400);

      }

      public function getPinDetails(Request $request)
      {
        $locations = Location::where('pincode', $request->input('id'))->first();
        return response()->json(['message'=>'data found!', 'state'=>$locations->state_name, 'city'=>$locations->city_name, 'location_id'=>$locations->id], 200);
      }

      public function findUser(Request $request)
      {
        
        
      $validatedData = $request->validate([
          'phone_number' => 'bail|required|numeric|digits_between:8,15',
          ]);

      $customer = User::where(['role'=> 4, 'deleted_at'=>null])
                  ->where('phone_number', 'like', $request->input('phone_number'))->with('wallet', 'addresses')->first();
      
      if ($customer) {
        $address = $customer->addresses;
        $orders = Order::where('customer_id', $customer->id)->latest()->first();
        if ($orders) {
            $address = null;
            if ($orders->count()) {
             $address = Address::where('id', $orders->address_id)->first();
            }
           
        }
      $wallet = $customer->wallet;
        session()->put('customer_details', ['user'=>$customer, 'wallet'=>$wallet]);
      
        return response()->json(["message"=>"Customer Found!!", "customer" => $customer, 'wallet'=>$wallet, 
                                  'address'=>$address], 200);
      }
        return response()->json(["message"=>"Customer Not Found!!"], 400);

      }

       public function setTimezone(Request $request)
      {
        if ($request->filled('timezone')) {
            $request->session()->put('user_timezone', $request->input('timezone'));
        }
        return response()->json(['message' => 'Timezone set successfully!'], 200);
      }

      public function setSessionAddress(sessionAddressRequest $request)
    { 
     $data = $request->only('address', 'city', 'state', 'pin', 'landmark', 'latitude', 'longitude');
     
     if ($request->input('user_id')) {
       $data['user_id']=$request->input('user_id');
       $address = Address::create($data);
       $data['address_id']=$address->id;
     }

     $data = session()->put('address', $data);

     $data = session()->get('address');
     if ($data) {
      return response()->json(["message"=>'Address Saved', 'data'=> $data], 200);
     }
     return response()->json(["message"=>'Address Not Saved', 'data'=>$data], 400);
    }


}
