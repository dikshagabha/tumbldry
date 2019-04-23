<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Model\Location;
use App\Model\Service;
use App\Model\Address;
use App\User;
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
        return view('admin.dashboard', compact('user', 'service'));
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
        $locations = Location::get();
        return view('admin.addAddressForm', compact('locations'));
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
}
