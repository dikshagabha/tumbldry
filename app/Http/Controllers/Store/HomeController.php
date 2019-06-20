<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\PickupRequest;
use App\Model\Address;
use App\Model\Order;
use App\Model\StoreFields;
use App\User;
use Auth;
use App\Notifications\StoreNotifications;
use App\Reports\MyReport;
use Carbon\Carbon;
use App\Http\Requests\Store\editProfileRequest;

use App\Repositories\Store\HomeRepository;

class HomeController extends Controller
{
    public function index(Request $Request)
    {

    	$activePage = 'dashboard';
    	$titlePage = "Dashboard";
     	$timezone = $Request->session()->get('user_timezone', 'Asia/Calcutta');

        

        $runners = User::where(['role'=>5, 'status'=>1, 'deleted_at'=>null])->where('user_id', Auth::user()->id)->pluck('name', 'id');
    	$users = PickupRequest::where('store_id', Auth::user()->id)->where('assigned_to', null)->wheredoesnthave('order')->with('order')->latest()->limit(5)->get();

        $pending = PickupRequest::where('store_id', Auth::user()->id)->where('status', '!=', '3')->where(
            'created_at', '<' , Carbon::now()->subHours(4))->limit(5)->get();

        $current_time = Carbon::now();
        if ($Request->ajax()) {
            return view('store.dashboard-list', compact('users', 'activePage', 'titlePage', 'runners','timezone', 'pending', 'current_time'));
        }

        return view('store.dashboard', compact('users', 'activePage', 'titlePage', 'runners','timezone', 'pending', 'current_time'));
    }

    public function newCustomers(Request $Request)
    {
        $date = Carbon::now();
        $user = User::where("user_id", Auth::user()->id)->get();
        $values = [];
        $data = [];
        for ($i=1; $i <= 6; $i++) { 
            //print_r($date);
            array_push($values,  $date->subMonth()->format('F'));
            $date = Carbon::now();

            array_push($data, 
                User::where("user_id", Auth::user()->id)->whereMonth('created_at', $date->subMonth($i))->count());
        }

        $values = array_reverse($values);
        $data = array_reverse($data);
        return response()->json(['values'=>$values, 'data'=>$data], 200);
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

    public function getCustomerAddresses(Request $request)
    {
        $address = Address::where('user_id', $request->input('user_id'))->get();

        //dd($address);
        return response()->json(['message' => 'Addresses Found', 'view'=>view('store.displayAddress', compact('address'))->render()], 200);
    }


    public function changePassword(Request $Request){

        $titlePage  = "Change Password";
        return view('store.auth.change-password', compact('titlePage'));
    }

    public function postchangePassword(Request $Request){

        $validate = $Request->validate([
            'old_password'=>'bail|required|string|min:2|max:15',
            'password'=>'bail|required|string|min:2|max:15|confirmed'
        ]);


        $user = Auth::user();

        if(!password_verify($Request->input('old_password'),$user->password)){
            return response()->json(['message' => 'The old password doesnot match.'], 400);
        }
        $user->password = bcrypt($Request->input('password'));
        if ($user->save()) {
            return response()->json(['message' => 'Password Changed.', 'redirectTo'=>route('store.home')], 200);
        }

         return response()->json(['message' => 'Something went wrong.'], 400);
    }


    public function editProfile(Request $Request){

        $titlePage  = "Edit Profile";

        $user = Auth::user();
        $users = User::where(['role'=>2, 'status'=>1])->pluck('store_name', 'id');

        $fields = StoreFields::get();
        $machines = $fields->where('type', 1)->pluck('name', 'id');
        $boiler = $fields->where('type', 2)->pluck('name', 'id');

        return view('store.auth.edit-profile', compact('titlePage', 'user', 'users', 'fields', 'machines', 'boiler'));
    }

    public function posteditProfile(editProfileRequest $Request){
      $id = Auth::user()->id;
      $response = HomeRepository::update($Request, $id);
      $http_status = $response['http_status'];
      $response['redirectTo'] = route('store.home');
      unset($response['http_status']);
      return response()->json($response, $http_status); 
    }
}
