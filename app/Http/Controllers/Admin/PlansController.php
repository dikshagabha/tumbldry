<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Plan;
use App\Model\UserAddress;
use App\Http\Requests\Admin\PlansRequest;
class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $activePage = 'plans';
        $titlePage  = 'Plans Details';
        $users = Plan::when($request->filled('search'), 
                function($query) use($request) {
                    $query->where(function($q) use($request) {
                            $q->where('name', 'like', '%' . $request->input('search') . '%');
                    });
                })
                ->when(($request->filled('sort_type') && in_array($request->input('sort_type'), [0, 1])), function($query) use($request) {
                    $query->where('status', $request->input('sort_type'));
               })->paginate(10);
               
        if ($request->ajax()) {
            return view('admin.manage-plans.list', compact('users', 'activePage', 'titlePage'));
        }

        return view('admin.manage-plans.index', compact('users', 'titlePage', 'activePage'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activePage = 'plans';
        $titlePage  = 'Create Plan';
       
        return view('admin.manage-plans.create', compact('address', 'titlePage', 'activePage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlansRequest $request)
    {
       

      $user = Plan::create($request->only('name', 'type', 'price', 'end_date', 'description'));
      return response()->json(["message"=>"Frenchise Added", "redirectTo"=>route('admin-manage-plans.index')], 200);
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
        $activePage = 'plan';
        $titlePage  = 'Edit Plan';

      $user = Plan::where("id", decrypt($id))->first();
     
      return view('admin.manage-plans.edit', compact('address', 'user', 'id', 'activePage', 'titlePage'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlansRequest $request, $id)
    {
      $user = Plan::where('id', decrypt($id))->update($request->only('name', 'type', 'price', 'end_date', 'description'));
      return response()->json(["message"=>"Plan Updated", "redirectTo"=>route('admin-manage-plans.index')], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {     $delete = Plan::where(['id'=>decrypt($id)])->delete();
          return response()->json(["message"=>"Plan deleted!"], 200);
    }
}
