<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Address;
use App\Model\UserAddress;
use App\Model\UserAccount;
use App\Model\UserProperty;
use App\Model\UserMachines;
use App\Model\UserImages;
use App\Model\StoreFields;
use DB;
use App\Http\Requests\Admin\AddStoreRequest;

use App\Repositories\Store\HomeRepository;
class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $activePage = 'store';
      $titlePage  = 'Store Details';
      $users = User::where('role', 3)
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
        return view('admin.manage-store.list', compact('users', 'activePage', 'titlePage'));

      }
      return view('admin.manage-store.index', compact('users', 'activePage', 'titlePage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $activePage = 'store';
      $titlePage  = 'Create Store';

      $users = User::where(['role'=>2, 'status'=>1])->pluck('store_name', 'id');
      
      $fields = StoreFields::get();
      $machines = $fields->where('type', 1)->pluck('name', 'id');
      $boiler = $fields->where('type', 2)->pluck('name', 'id');

      return view('admin.manage-store.create', compact('users', 'activePage', 'titlePage', 'machines', 'boiler'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddStoreRequest $request)
    {
      $response = HomeRepository::store($request);
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

       $user = User::where("id", $id)->first();
       $data = StoreFields::whereIn('id', [$user->machine_type, $user->boiler_type])->get();
       return view("admin.manage-store.show", compact('user', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $activePage = 'store';
      $titlePage  = 'Edit Store';

      $user = User::where("id", decrypt($id))->first();
      $users = User::where(['role'=>2, 'status'=>1])->pluck('store_name', 'id');

      $fields = StoreFields::get();
      $machines = $fields->where('type', 1)->pluck('name', 'id');
      $boiler = $fields->where('type', 2)->pluck('name', 'id');

      return view('admin.manage-store.edit', compact('address', 'user', 'id', 'users', 'activePage', 'titlePage', 'machines', 'boiler'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddStoreRequest $request, $id)
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
      return response()->json(["message"=>"Store deleted!"], 200);
    }

    public function saveSession(Request $request, $id)
    {
     
     if ($id==1) {
         $validatedData = $request->validate([
          'email' => 'bail|required|email|unique:users,email',
          'name' => 'bail|required|min:2|max:50|string',
          'user_id'=>['bail', 'nullable', 'numeric'],
          'store_name' => 'bail|nullable|min:2|max:50|string',
          'phone_number' => 'bail|required|unique:users,phone_number|min:2|max:999999999',
        ]);

        $request->session()->put('store_data', $request->only("address_id", 'email', 'name', 'store_name', 'phone_number'));
        return response()->json(["message"=>'Data stored temporarly'], 200);
     }
      else if($id==2){
        $validatedData = $request->validate([
          'email' => 'bail|required|email|unique:users,email',
          'name' => 'bail|required|min:2|max:50|string',
          
          'user_id'=>['bail','nullable', 'numeric'],
          'store_name' => 'bail|nullable|min:2|max:50|string',
          'phone_number' => 'bail|required|unique:users,phone_number|min:2|max:999999999',
          
          'address'=>'bail|nullable|string|min:2|max:50',
          'city'=>'bail|nullable|string|min:2|max:50',
          'state'=>'bail|nullable|string|min:2|max:50',
          
          'pin'=>'bail|required|numeric|min:2|max:999999',
          'latitude'=>'bail|nullable|numeric|min:-180|max:180',
          'longitude'=>'bail|nullable|numeric|min:-180|max:180',
          'landmark'=>'bail|nullable|string|min:2|max:200',

        ]);
      }
     else if($id==3){
      $validatedData = $request->validate([
          'email' => 'bail|required|email|unique:users,email',
          'name' => 'bail|required|min:2|max:50|string',
          'user_id'=>['bail','nullable', 'numeric'],
          'store_name' => 'bail|nullable|min:2|max:50|string',
          'phone_number' => 'bail|required|unique:users,phone_number|min:2|max:999999999',
           
           'address'=>'bail|nullable|string|min:2|max:50',
          'city'=>'bail|nullable|string|min:2|max:50',
          'state'=>'bail|nullable|string|min:2|max:50',
          
          'pin'=>'bail|nullable|numeric|min:2|max:999999',
          'latitude'=>'bail|nullable|numeric|min:-180|max:180',
          'longitude'=>'bail|nullable|numeric|min:-180|max:180',
          'landmark'=>'bail|nullable|string|min:2|max:200',

          'machine_count'=>'bail|nullable|numeric|min:1|max:9999',
          'boiler_count'=>'bail|nullable|numeric|min:1|max:9999',
          'machine_type'=>'bail|nullable|string|min:1|max:500',
          'boiler_type'=>'bail|nullable|string|min:1|max:500',
          'iron_count'=>'bail|nullable|numeric|min:1|max:9999',
        ]);

        $request->session()->put('store_data', $request->only("address_id", 'email', 'name', 'store_name', 'phone_number', 'machine_count','machine_type', 'boiler_type', 'boiler_count'));
        return response()->json(["message"=>'Data stored temporarly'], 200);
     }

     else if($id==4){
      $validatedData = $request->validate([
          'email' => 'bail|required|email|unique:users,email',
          'name' => 'bail|required|min:2|max:50|string',
          
          'user_id'=>['bail','nullable', 'numeric'],
          'store_name' => 'bail|nullable|min:2|max:50|string',
          'phone_number' => 'bail|required|unique:users,phone_number|min:2|max:999999999',
          
          'address'=>'bail|nullable|string|min:2|max:50',
          'city'=>'bail|nullable|string|min:2|max:50',
          'state'=>'bail|nullable|string|min:2|max:50',
          'pin'=>'bail|nullable|numeric|min:2|max:999999',
          'latitude'=>'bail|nullable|numeric|min:-180|max:180',
          'longitude'=>'bail|nullable|numeric|min:-180|max:180',
          'landmark'=>'bail|nullable|string|min:2|max:200',


          'machine_count'=>'bail|nullable|numeric|min:1|max:9999',
          'boiler_count'=>'bail|nullable|numeric|min:1|max:9999',
          'machine_type'=>'bail|nullable|string|min:1|max:500',
          'boiler_type'=>'bail|nullable|string|min:1|max:500',
          'iron_count'=>'bail|nullable|numeric|min:1|max:9999',
          
          'property_type'=>'bail|required|numeric|min:1|max:2',
          'store_size'=>'bail|required_if:property_type,1|nullable|numeric|min:1|max:9999',
          'store_rent'=>'bail|required_if:property_type,1|nullable|numeric|min:1|max:9999',
          'rent_enhacement'=>'bail|required_if:property_type,1|nullable|numeric|min:1|max:9999',
          'rent_enhacement_percent'=>'bail|required_if:property_type,1|nullable|numeric|min:1|max:99',
          'landlord_name' => 'bail|required_if:property_type,1|nullable|min:2|max:50|string',
          'landlord_number' => 'bail|required_if:property_type,1|nullable|min:2|max:999999999|numeric',
        ]);

        $request->session()->put('store_data', $request->only("address_id", 'email', 'name', 'store_name', 'phone_number', 'machine_count','machine_type', 'boiler_type', 'boiler_count',
          'property_type', 'store_size', 'store_rent', 'rent_enhacement', 'rent_enhacement_percent', 
          'landlord_name', 'landlord_number'));
        return response()->json(["message"=>'Data stored temporarly'], 200);
     }

     else if($id==4){
      $validatedData = $request->validate([
          'email' => 'bail|required|email|unique:users,email',
          'name' => 'bail|required|min:2|max:50|string',
          
          'user_id'=>['bail', 'nullable', 'numeric'],
          'address'=>'bail|nullable|string|min:2|max:50',
          'city'=>'bail|nullable|string|min:2|max:50',
          'state'=>'bail|nullable|string|min:2|max:50',
          'pin'=>'bail|nullable|numeric|min:2|max:999999',
          'latitude'=>'bail|nullable|numeric|min:-180|max:180',
          'longitude'=>'bail|nullable|numeric|min:-180|max:180',
          'landmark'=>'bail|nullable|string|min:2|max:200',

          'store_name' => 'bail|nullable|min:2|max:50|string',
          'phone_number' => 'bail|required|unique:users,phone_number|min:2|max:999999999',
          'machine_count'=>'bail|nullable|numeric|min:1|max:9999',
          'boiler_count'=>'bail|nullable|numeric|min:1|max:9999',
          'machine_type'=>'bail|nullable|string|min:1|max:500',
          'boiler_type'=>'bail|nullable|string|min:1|max:500',
          'iron_count'=>'bail|nullable|numeric|min:1|max:9999',
          
          'property_type'=>'bail|required|numeric|min:1|max:2',
          'store_size'=>'bail|required_if:property_type,1|nullable|numeric|min:1|max:9999',
          'store_rent'=>'bail|required_if:property_type,1|nullable|numeric|min:1|max:9999',
          'rent_enhacement'=>'bail|required_if:property_type,1|nullable|numeric|min:1|max:9999',
          'rent_enhacement_percent'=>'bail|required_if:property_type,1|nullable|numeric|min:1|max:99',
          'landlord_name' => 'bail|required_if:property_type,1|nullable|min:2|max:50|string',
          'landlord_number' => 'bail|required_if:property_type,1|nullable|min:2|max:999999999|numeric',

          'address_proof' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'gst_certificate' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'bank_passbook' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'cheque' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'pan' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'id_proof' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'loi_copy' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'transaction_details' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'agreement_copy' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'rent_agreement' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
        ]);

      
        $request->session()->put('store_data', $request->only("address_id", 'email', 'name', 'store_name', 'phone_number', 'machine_count','machine_type', 'boiler_type', 'boiler_count',
          'property_type', 'store_size', 'store_rent', 'rent_enhacement', 'rent_enhacement_percent', 
          'landlord_name', 'landlord_number'));
        return response()->json(["message"=>'Data stored temporarly'], 200);
     }
    }

    public function status(Request $request, $id)
    {
      $delete = User::where(['id'=>$id])->update($request->only('status'));
      if($delete){
        return response()->json(["message"=>"Store updated!"], 200);
      }
      return response()->json(["message"=>"Something went wrong!"], 400);
    }
}
