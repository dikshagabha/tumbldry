<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\{
  PickupRequest,
  Address,
  Order
};
use Auth;
use App\Repositories\Customer\HomeRepository;

use Mail;
use App\Mail\Runner\SendPassword;

use App\Http\Requests\Customer\Auth\RegisterRequest;
use App\Http\Requests\Customer\Auth\AddressRequest;
use App\Http\Requests\Customer\Auth\UpdateRequest;

class CustomerController extends Controller
{

    protected $user;
    public function __construct(){

          // if the user is logged in then fetches the details of the user
          $this->middleware(function($request, $next) {
              $this->user = Auth::user();
              return $next($request);
          });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $activePage = 'customer';
      $titlePage  = 'Customer Details';
      $users = User::where('role', 4)->where('user_id', Auth::user()->id)
              ->when($request->filled('search'), 
                function($query) use($request) {
                  $query->where(function($q) use($request) {
                    $q->where('name', 'like', '%' . $request->input('search') . '%')
                          ->orWhere('email', 'like', '%' . $request->input('search') . '%')
                          ->orWhere('phone_number', 'like', '%' . $request->input('search') . '%');
                    
                  });
                })->when(($request->filled('sort_type') && in_array($request->input('sort_type'), [0, 1])), function($query) use($request) {
                $query->where('status', $request->input('sort_type'));
               })
               ->latest()->paginate(10);
      if ($request->ajax()) {
        //dd($users);
        return view('store.manage-customer.list', compact('users', 'activePage', 'titlePage'));

      }
      return view('store.manage-customer.index', compact('users', 'activePage', 'titlePage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $activePage = 'customer';
      $titlePage  = 'Create Customer';
      session()->forget('address');
      return view('store.manage-customer.create', compact('users', 'activePage', 'titlePage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
      $address = session()->get('address');
      $response = HomeRepository::store($request, Auth::user()->id, $address);
      $http_status = $response['http_status'];
      unset($response['http_status']);
      return response()->json($response, $http_status); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = decrypt($id);

       $user = User::where("id", $id)->with('customer_addresses')->first();
      // $data = StoreFields::whereIn('id', [$user->machine_type, $user->boiler_type])->get();
       return view("store.manage-customer.show", compact('user', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $activePage = 'customer';
      $titlePage  = 'Edit Customer';

      $user = User::where("id", decrypt($id))->with('customer_addresses')->first();
      $session = session()->put('address',$user->customer_addresses()->select('user_id', 'address', 'landmark', 'latitude','longitude', 'city', 'state', 'pin')->get()->toArray());
      //dd(session()->get('address'));
      return view('store.manage-customer.edit', compact('user', 'id','activePage', 'titlePage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
      //$id = decrypt($id);
      $address = session()->get('address');
      $response = HomeRepository::update($request, decrypt($id), Auth::user() ,$address);
      $http_status = $response['http_status'];
      unset($response['http_status']);
      return response()->json($response, $http_status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


      //$delete =  null
      //if (!$pickup) {
        $delete = User::where(['id'=>decrypt($id)])->delete();
      //}

      if ($delete) {
        return response()->json(["message"=>"Store deleted!"], 200);
      }
      return response()->json(["message"=>"Something went wrong !"], 400);
    }

    public function status(Request $request, $id)
    {
      $delete = User::where(['id'=>$id])->update($request->only('status'));
      if($delete){
        return response()->json(["message"=>"Store updated!"], 200);
      }
      return response()->json(["message"=>"Something went wrong!"], 400);
    }

    public function setSessionAddress(AddressRequest $request)
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


    public function setSessionAddresses(AddressRequest $request)
    { 
     $details = $request->only('address', 'city', 'state', 'pin', 'landmark', 'latitude', 'longitude');
     if ($request->input('user_id')) {
       $details['user_id']=$request->input('user_id');
       $address = Address::create($details);
       $details['address_id']=$address->id;
     }
     $data = session()->get('address');
     if ($data) {
       array_push($data, $details);
       session()->put('address', $data);
     }else{
      session()->put('address', [$details]);
     }

     $data = session()->get('address');

     
     if ($data) {
      return response()->json(["message"=>'Address Saved', 'view'=> view('store.showMultipleAddressess', compact('data'))->render()], 200);
     }
     return response()->json(["message"=>'Address Not Saved', 'data'=>$data], 400);
    }

    public function deleteSessionAddresses(Request $request){
    $items = session('address');
    $index = $request->input('data-id')-1;
    
    unset($items[$index]);

    $items = array_values($items);
    session()->put("address", $items);

    $data = session('address');
   
    return response()->json(['message'=>'Address Deleted', 'view'=> view('store.showMultipleAddressess', compact('data'))->render()], 200);
    }

    public function customerDetails(Request $request, $id){
      $activePage = 'customer';
      $titlePage = 'Customer Details';
      $orders = Order::where(['customer_id'=>$id, 'store_id'=>$this->user->id])->latest()->get();
      
      $pending = $orders->where('status', '!=', 6);
      $delivered = $orders->where('status', 6);
      $total = $orders->count();
       $timezone = $request->session()->get('user_timezone', 'Asia/Calcutta');
      if ($request->ajax()) {
        return view('store.manage-customer.details-list', compact('orders', 'pending', 'total', 'activePage', 'titlePage','timezone', 'delivered'));
      }
        return view('store.manage-customer.details', compact('orders', 'pending', 'total', 'activePage', 'titlePage','timezone', 'delivered'));

    }

    public function latestcustomerDetails(Request $request, $id){
      $activePage = 'customer';
      $titlePage = 'Customer Details';
      $orders = Order::where(['customer_id'=>$id, 'store_id'=>$this->user->id])->latest()->get();
      $pending = Order::where(['customer_id'=>$id, 'store_id'=>$this->user->id])->where('status', '!=', 6)->latest()->limit(5)->get();
      $delivered = Order::where(['customer_id'=>$id, 'store_id'=>$this->user->id])->where('status', 6)->latest()->limit(5)->get();
      $total = $orders->count();
       $timezone = $request->session()->get('user_timezone', 'Asia/Calcutta');
      if ($request->ajax()) {
        return view('store.manage-customer.details-list', compact('orders', 'pending', 'total', 'activePage', 'titlePage','timezone', 'delivered', 'id'));
      }
        return view('store.manage-customer.details', compact('orders', 'pending', 'total', 'activePage', 'titlePage','timezone', 'delivered'
      , 'id'));

    }
}
