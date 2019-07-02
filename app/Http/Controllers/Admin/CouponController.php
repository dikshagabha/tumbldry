<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Address;
use App\Model\Items;
use App\Model\Coupon;
use App\Model\Service;
use App\Http\Requests\Admin\StoreFrenchiseRequest;
use Carbon\Carbon;
class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $activePage = 'coupon';
        $titlePage  = 'Coupons Details';
        $users = Coupon::when($request->filled('search'), 
                function($query) use($request) {
                    $query->where(function($q) use($request) {
                            $q->where('coupon', 'like', '%' . $request->input('search') . '%');
                            
                });
                })->latest()
                ->paginate(10);
               // dd($users);
        if ($request->ajax()) {
            return view('admin.coupon.list', compact('users', 'activePage', 'titlePage'));
        }

        return view('admin.coupon.index', compact('users', 'titlePage', 'activePage'));

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

       $activePage = 'coupon';
        $titlePage  = 'Coupons Edit';
      $coupon = Coupon::where("id", decrypt($id))->first();
      $service = Service::where('type', 1)->pluck('name', 'id');

      $weekdays = [1=>'Monday', 2=>'Tuesday', 3=>'Wednesday', 4=>'Thursday', 5=>'Friday', 6=>'Saturday', 7=>'Sunday'];
      return view('admin.coupon.edit', compact('coupon', 'titlePage', 'activePage', 'id', 'service', 'weekdays'));
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
      $request->validate(['coupon'=>'bail|required|string|min:3|max:20',
                            'coupon_price'=>'bail|required|numeric|min:1|max:100']);      
      $user = Coupon::where('id', decrypt($id))->update($request->only('coupon', 'coupon_price', 'parameter', 'value'));
      
      return response()->json(["message"=>"Coupon Updated", "redirectTo"=>route('edit-coupons.index')], 200);
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
