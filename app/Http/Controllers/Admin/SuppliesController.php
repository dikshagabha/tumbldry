<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Address;
use App\Model\Items;
use App\Http\Requests\Admin\StoreFrenchiseRequest;
class SuppliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $activePage = 'frenchise';
        $titlePage  = 'Franchise Details';
        $users = Items::where(['type'=>11])
                ->when($request->filled('search'), 
                function($query) use($request) {
                    $query->where(function($q) use($request) {
                            $q->where('name', 'like', '%' . $request->input('search') . '%');
                            
                          });
                })->latest()
                ->paginate(10);
               // dd($users);
        if ($request->ajax()) {
            return view('admin.manage-supplies.list', compact('users', 'activePage', 'titlePage'));
        }

        return view('admin.manage-supplies.index', compact('users', 'titlePage', 'activePage'));

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
    public function store(Request $request)
    {
       $request->validate(['name'=>'bail|required|string|min:3|max:20']);

      $user = Items::create(['name'=>$request->input('name'), 'type'=>11]);

      //$add = UserAddress::create(['user_id'=>$user->id, 'address_id'=>$request->input('address_id')]);

      return response()->json(["message"=>"Supply Added", "redirectTo"=>route('manage-frenchise.index')], 200);
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
       
      $user = Items::where("id", decrypt($id))->first();
      return response()->json(["name"=>$user->name, 'url'=>route('manage-supplies.update', $id)], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate(['name'=>'bail|required|string|min:3|max:20']);
      $user = Items::where('id', decrypt($id))->update(['name'=>$request->input('name')]);
      
      return response()->json(["message"=>"Supply Updated", "redirectTo"=>route('manage-frenchise.index')], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {     $delete = Items::where(['id'=>decrypt($id)])->delete();
        //  $delete = UserAddress::where(['user_id'=>decrypt($id)])->delete();
          return response()->json(["message"=>"Frenchise deleted!"], 200);
    }
}
