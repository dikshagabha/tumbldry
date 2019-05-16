<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Model\Location;
use App\Model\Service;
use App\Model\Address;
use App\User;

use App\Model\ServicePrice;

use App\Model\Items;

use App\Http\Requests\Admin\AddAddressRequest;
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
        $this->middleware('auth');
        $this->user=Auth::user();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $user = User::get();
       $service = Service::count();

        $cities = Location::groupBy('city_name')->selectRaw('city_name')->orderBy('city_name', 'asc')->pluck('city_name', 'city_name');

        $cities['global']='Global';

        $types = [1=>"Dry Clean", 2=>"Laundary", 3=>'Car Clean'];
      
        return view('admin.dashboard', compact('user', 'service', 'cities', 'types' ));
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
          'phone_number' => 'bail|required|numeric|min:2|max:9999999999',
          ]);

        $customer = User::where('phone_number', 'like', '%'.$request->input('phone_number').'%')->first();
        
        if ($customer) {
          return response()->json(["message"=>"User Found!!", "user" => $customer], 200);
        }
          return response()->json(["message"=>"User Not Found!!"], 400);

      }

       public function setTimezone(Request $request)
    {
        if ($request->filled('timezone')) {
            $request->session()->put('user_timezone', $request->input('timezone'));
        }
        return response()->json(['message' => 'Timezone set successfully!'], 200);
    }
}
