<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PickupRequest;
use DB;

class PickupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $activePage = 'pickup-request';
      $titlePage  = 'Pickup Request';
       $users = PickupRequest::
       //where('role', 3)
      //         ->when($request->filled('search'), 
      //           function($query) use($request) {
      //             $query->where(function($q) use($request) {
      //               $q->where('name', 'like', '%' . $request->input('search') . '%')
      //                     ->orWhere('email', 'like', '%' . $request->input('search') . '%')
      //                     ->orWhere('phone_number', 'like', '%' . $request->input('search') . '%');
                    
      //             });
      //           })->when(($request->filled('sort_type') && in_array($request->input('sort_type'), [0, 1])), function($query) use($request) {
      //           $query->where('status', $request->input('sort_type'));
      //          })
               latest()->paginate(10);
      if ($request->ajax()) {
        //dd($users);
        return view('admin.pickup-request.list', compact('users', 'activePage', 'titlePage'));

      }
      return view('admin.pickup-request.index', compact('users', 'activePage', 'titlePage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
