<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Service;
use App\Model\ServicePrice;
use App\Http\Requests\Admin\StoreServiceRequest;
class ServiceController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $users = Service::with('serviceprices')->paginate(10);
      return view('admin.manage-service.index', compact('users'));

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      return view('admin.manage-service.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreServiceRequest $request)
  {
    $user = Service::create(['name'=>$request->input('name'), 'description'=>$request->input('description'),
   'type'=>$request->input('type')]);
    $insertData=[];
    foreach ($request->input('price') as $key => $value) {
      ServicePrice::create(["service_id"=>$user->id, 'parameter'=>$request->input('parameter')[$key], 'value'=>$value ]);
    }
   return response()->json(["message"=>"Service Added", "redirectTo"=>route('manage-service.index')], 200);
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
      $service = Service::where("id", $id)->with('serviceprices')->first();
      return view('admin.manage-service.edit', compact('service', 'id'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(StoreServiceRequest $request, $id)
  {
    $user = Service::where('id', $id)->update(
      ['name'=>$request->input('name'), 'description'=>$request->input('description'), 'type'=>$request->input('type') ]);
    $insertData=[];
    ServicePrice::where('service_id', $id)->delete();
    foreach ($request->input('price') as $key => $value) {
      ServicePrice::create(["service_id"=>$id, 'parameter'=>$request->input('parameter')[$key], 'value'=>$value ]);
    }
   return response()->json(["message"=>"Service Updated ", "redirectTo"=>route('manage-service.index')], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $delete = Service::where(['id'=>decrypt($id)])->delete();
    $delete = ServicePrice::where(['service_id'=>decrypt($id)])->delete();
    return response()->json(["message"=>"Service deleted!"], 200);
  }
}
