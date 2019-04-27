<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Address;
use App\Model\UserAddress;
use App\Http\Requests\Admin\StoreFrenchiseRequest;
class FranchiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activePage = 'frenchise';
        $titlePage  = 'Franchise Details';
        $users = User::where('role', 2)->paginate(10);


        return view('admin.manage-franchise.index', compact('users', 'titlePage', 'activePage'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activePage = 'frenchise';
        $titlePage  = 'Create Franchise';
        $address = Address::get();
        return view('admin.manage-franchise.create', compact('address', 'titlePage', 'activePage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFrenchiseRequest $request)
    {
       

      $user = User::create(['name'=>$request->input('name'),'store_name'=>$request->input('store_name'),'email'=>$request->input('email'),'phone_number'=>$request->input('phone_number'), 'role'=>2]);

      //$add = UserAddress::create(['user_id'=>$user->id, 'address_id'=>$request->input('address_id')]);

      return response()->json(["message"=>"Frenchise Added", "redirectTo"=>route('manage-frenchise.index')], 200);
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
        $activePage = 'frenchise';
        $titlePage  = 'Edit Franchise';

      $user = User::where("id", decrypt($id))->first();
      $address = Address::get();
      return view('admin.manage-franchise.edit', compact('address', 'user', 'id', 'activePage', 'titlePage'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFrenchiseRequest $request, $id)
    {
      $user = User::where('id', decrypt($id))->update(['name'=>$request->input('name'), 
                            'store_name'=>$request->input('store_name'),'email'=>$request->input('email'),'phone_number'=>$request->input('phone_number')]);
      //$delete = UserAddress::where(['user_id'=>decrypt($id)])->delete();
      //$add = UserAddress::create(['user_id'=>decrypt($id), 'address_id'=>$request->input('address_id')]);

      return response()->json(["message"=>"Frenchise Updated", "redirectTo"=>route('manage-frenchise.index')], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {     $delete = User::where(['id'=>decrypt($id)])->delete();
        //  $delete = UserAddress::where(['user_id'=>decrypt($id)])->delete();
          return response()->json(["message"=>"Frenchise deleted!"], 200);
    }
}
