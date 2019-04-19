<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Address;
use App\Model\UserAddress;
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
      $user = User::create(['name'=>$request->input('name'), 'role'=>3, 'email'=> $request->input('email')
                            , 'phone_number'=> $request->input('phone_number'), 'store_name'=> $request->input('store_name')]);

      $add = UserAddress::create(['user_id'=>$user->id, 'address_id'=>$request->input('address_id')]);
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
}
