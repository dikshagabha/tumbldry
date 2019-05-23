<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

use Auth;
use App\Repositories\Vendor\HomeRepository;

use App\Http\Requests\Vendor\Auth\RegisterRequest;
use App\Http\Requests\Vendor\Auth\UpdateRequest;
use App\Http\Requests\Vendor\createVendorProviderRequest;
use DB;
class VendorController extends Controller
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
      $activePage = 'vendor';
      $titlePage  = 'Vendor Details';
      $users = User::where('role', 6)->where('user_id', $this->user->id)
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
        return view('store.manage-vendor.list', compact('users', 'activePage', 'titlePage'));

      }
      return view('store.manage-vendor.index', compact('users', 'activePage', 'titlePage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $activePage = 'vendor';
      $titlePage  = 'Create Vendor';
      session()->forget('providers');
      return view('store.manage-vendor.create', compact('users', 'activePage', 'titlePage'));
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
      $providers = session()->get('providers');
      $response = HomeRepository::store($request, $this->user, $address, $providers);
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

       $user = User::where("id", $id)->with('addresses', 'users')->first();
      // $data = StoreFields::whereIn('id', [$user->machine_type, $user->boiler_type])->get();
       return view("store.manage-vendor.show", compact('user', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $activePage = 'vendor';
      $titlePage  = 'Edit Vendor';

      $user = User::where("id", decrypt($id))->first();
      
      return view('store.manage-vendor.edit', compact('user', 'id','activePage', 'titlePage'));
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
        $id = decrypt($id);
      $response = HomeRepository::update($request, $id);
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
      $delete = User::where(['id'=>decrypt($id)])->delete();
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

    public function setSessionProviders(createVendorProviderRequest $request)
    {
      $data = session()->get('providers');
      $details = ['name'=>$request->input('vendor_name'),'phone_number'=>$request->input('vendor_phone_number'), 'email'=>$request->input('vendor_email'), 'address'=>['city'=>$request->input('vendor_city'), 'state'=>$request->input('vendor_state'), 'pin'=>$request->input('vendor_pin'), 'latitude'=>$request->input('vendor_latitude'), 'longitude'=>$request->input('vendor_longitude'), 'address'=>$request->input('vendor_address')] 
      ];
      
      if (!$data) {
        $data = session()->put('providers', [ $details ]);
      }else{
        array_push($data, $details);
        
        session()->put('providers', $data);
      }
      
      $data = session()->get('providers');

      if ($data) {
        return response()->json(["message"=>'Address Saved', 'data'=>$data], 200);
      }
       return response()->json(["message"=>'Address Not Saved', 'data'=>$data], 400);

    }
}
