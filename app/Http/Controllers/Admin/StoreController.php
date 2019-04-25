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
use DB;
use App\Http\Requests\Admin\AddStoreRequest;
class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $users = User::where('role', 3)->with(['address'=> function($q){
        $q->with('addressdetails')->first();
      }])->paginate(10);

      return view('admin.manage-store.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $address = Address::get();
      return view('admin.manage-store.create', compact('address'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddStoreRequest $request)
    {


      try {
        DB::beginTransaction();

        $user = User::create(['name'=>$request->input('name'), 'role'=>3, 'email'=> $request->input('email')
                            , 'phone_number'=> $request->input('phone_number'), 'store_name'=> $request->input('store_name')]);

        $add = UserAddress::create(['user_id'=>$user->id, 'address_id'=>$request->input('address_id')]);

        $machines =  UserMachines::create([
                                          'user_id'=>$user->id,
                                          'machine_count'=>$request->input('machine_count'),
                                          'boiler_count'=>$request->input('boiler_count'),
                                          'machine_type'=>$request->input('machine_type'),
                                          'boiler_type'=>$request->input('boiler_type'),
                                          'iron_count'=>$request->input('iron_count') ,
                                          
                                          
                                          ]);
        $property =  UserProperty::create([
                                          'user_id'=>$user->id,
                                          'property_type'=>$request->input('property_type'),
                                          'store_size'=>$request->input('store_size') ,
                                          'store_rent'=>$request->input('store_rent'),
                                          'landlord_number'=>$request->input('landlord_number'),
                                          'landlord_name'=>$request->input('landlord_name'),
                                          'rent_enhacement_percent'=>$request->input('rent_enhacement_percent') ,
                                          'rent_enhacement'=>$request->input('rent_enhacement'),
                                          ]);

        $account =  UserAccount::create([
                                          'account_number'=>$request->input('account_number') ,
                                          'user_id'=>$user->id,
                                          'bank_name'=>$request->input('bank_name'),
                                          'branch_code'=>$request->input('branch_code'),
                                          'ifsc_code'=>$request->input('ifsc_code'),
                                          'gst_number'=>$request->input('gst_number') ,
                                          'pan_card_number'=>$request->input('pan_card_number'),
                                          'id_proof_number'=>$request->input('id_proof_number'),
                                          ]);
        $img_array =['user_id'=>$user->id];

         foreach (['address_proof', 'gst_certificate', 'bank_passbook', 'cheque', 'pan', 'id_proof',
                    'loi_copy', 'agreement_copy', 'rent_agreement', 'transaction_details'] as $key => $value)
         {

         
            if($request->file($value))
             {

                $image = $request->file($value);
                $name=$image->getClientOriginalName().time().$user->id;
                $image->move(public_path().'/uploaded_images/', $name);   
                array_push($img_array, [$value=>$name]);
                       
             }
         }

         
         $images =  UserImages::create($img_array);
        DB::commit();
        return response()->json(["message"=>"Store Added", 'redirectTo'=>route('manage-store.index')], 200);
      }
      catch (\Exception $e) {
        return response()->json(["message"=>$e->getMessage()], 400);
          return $e->getMessage();
      }
      
      
      return response()->json(["message"=>"Store Added", 'redirectTo'=>route('manage-store.index')], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $user = User::where("id", decrypt($id))->with("address")->first();
      $address = Address::get();
      return view('admin.manage-store.edit', compact('address', 'user', 'id'));
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
      $user = User::where('id', decrypt($id))->update(['name'=>$request->input('name'), 'email'=>$request->input('email'), 'phone_number'=>$request->input('phone_number'),
                                                       'store_name'=>$request->input('store_name')]);
      $delete = UserAddress::where(['user_id'=>decrypt($id)])->delete();
      $add =  UserAddress::create(['user_id'=>decrypt($id), 'address_id'=>$request->input('address_id')]);

      return response()->json(["message"=>"Store Updated", "redirectTo"=>route('manage-store.index')], 200);
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
      $delete = UserAddress::where(['user_id'=>decrypt($id)])->delete();
      return response()->json(["message"=>"Store deleted!"], 200);
    }

    public function saveSession(Request $request, $id)
    {
     
     if ($id==1) {
         $validatedData = $request->validate([
          'email' => 'bail|required|unique:users,email',
          'name' => 'bail|required|min:2|max:50|string',
          //'address_id'=>['bail','required', 'numeric'],
          'store_name' => 'bail|required|min:2|max:50|string',
          'phone_number' => 'bail|required|unique:users,phone_number|min:2|max:999999999',
        ]);

        $request->session()->put('store_data', $request->only("address_id", 'email', 'name', 'store_name', 'phone_number'));
        return response()->json(["message"=>'Data stored temporarly'], 200);
     }
     else if($id==2){
      $validatedData = $request->validate([
          'email' => 'bail|required|unique:users,email',
          'name' => 'bail|required|min:2|max:50|string',
          //'address_id'=>['bail','required', 'numeric'],
          'store_name' => 'bail|required|min:2|max:50|string',
          'phone_number' => 'bail|required|unique:users,phone_number|min:2|max:999999999',
          
          'machine_count'=>'bail|required|numeric|min:1|max:9999',
          'boiler_count'=>'bail|required|numeric|min:1|max:9999',
          'machine_type'=>'bail|required|string|min:1|max:500',
          'boiler_type'=>'bail|required|string|min:1|max:500',
          'iron_count'=>'bail|required|numeric|min:1|max:9999',
        ]);

        $request->session()->put('store_data', $request->only("address_id", 'email', 'name', 'store_name', 'phone_number', 'machine_count','machine_type', 'boiler_type', 'boiler_count'));
        return response()->json(["message"=>'Data stored temporarly'], 200);
     }

     else if($id==3){
      $validatedData = $request->validate([
          'email' => 'bail|required|unique:users,email',
          'name' => 'bail|required|min:2|max:50|string',
          //'address_id'=>['bail','required', 'numeric'],
          'store_name' => 'bail|required|min:2|max:50|string',
          'phone_number' => 'bail|required|unique:users,phone_number|min:2|max:999999999',
          
          'machine_count'=>'bail|required|numeric|min:1|max:9999',
          'boiler_count'=>'bail|required|numeric|min:1|max:9999',
          'machine_type'=>'bail|required|string|min:1|max:500',
          'boiler_type'=>'bail|required|string|min:1|max:500',
          'iron_count'=>'bail|required|numeric|min:1|max:9999',
          
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
          'email' => 'bail|required|unique:users,email',
          'name' => 'bail|required|min:2|max:50|string',
          //'address_id'=>['bail','required', 'numeric'],
          'store_name' => 'bail|required|min:2|max:50|string',
          'phone_number' => 'bail|required|unique:users,phone_number|min:2|max:999999999',
          'machine_count'=>'bail|required|numeric|min:1|max:9999',
          'boiler_count'=>'bail|required|numeric|min:1|max:9999',
          'machine_type'=>'bail|required|string|min:1|max:500',
          'boiler_type'=>'bail|required|string|min:1|max:500',
          'iron_count'=>'bail|required|numeric|min:1|max:9999',
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
}
