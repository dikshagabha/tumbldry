<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\PickupRequest;
use App\Model\Address;
use App\Model\Order;
use App\User;
use Auth;
use App\Notifications\StoreNotifications;
use App\Reports\MyReport;

class HomeController extends Controller
{
    public function index(Request $Request)
    {

    	$activePage = 'dashboard';
    	$titlePage = "Dashboard";
     	$timezone = $Request->session()->get('user_timezone', 'Asia/Calcutta');

        

        $runners = User::where(['role'=>5, 'status'=>1])->where('user_id', Auth::user()->id)->pluck('name', 'id');
    	$users = PickupRequest::where('store_id', Auth::user()->id)->wheredoesnthave('order')->with('order')->latest()->paginate(5);
        
    	if ($Request->ajax()) {
    		return view('store.pickup-requests.list', compact('users', 'activePage', 'titlePage', 'runners', 'timezone'));
    	}
    	
    	return view('store.pickup-requests.index', compact('users', 'activePage', 'titlePage', 'runners','timezone'));
    }

    public function getcustomerdetails(Request $Request, $id)
    {
       
        $user = User::where("id", $id)->first();

        return view('store.customer_details_modal', compact('user'));
    }

    public function getaddressdetails(Request $Request, $id)
    {
       
        $user = Address::where("id", $id)->first();

        return view('store.address_details_modal', compact('user'));
    }

    public function findCustomer(Request $request)
    {
      $validatedData = $request->validate([
          'phone_number' => 'bail|required|numeric|min:2|max:9999999999',
          ]);

      $customer = User::where('role', 4)
                  ->where('phone_number', 'like', $request->input('phone_number'))->with('wallet', 'addresses')->first();
      $address = $customer->addresses;
	if ($customer) {
        $orders = Order::where('customer_id', $customer->id)->latest()->first();
        if ($orders) {
            $address = null;
            if ($orders->count()) {
             $address = Address::where('id', $orders->address_id)->first();
            }
            //$wallet = $customer->wallet;
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

    public function getCustomerAddresses(Request $request)
    {
        $address = Address::where('user_id', $request->input('user_id'))->get();

        //dd($address);
        return response()->json(['message' => 'Addresses Found', 'view'=>view('store.displayAddress', compact('address'))->render()], 200);
    }

}
