<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\{
	Service,
	ServicePrice,
	Location
};
use App\User;

class RateCardController extends Controller
{
    
    protected $user;
	protected $useraddress;
	protected $location;

	public function __construct(){
    $this->middleware(function($request, $next) {
        $this->user = Auth::user()->load('addresses');
        $this->useraddress = $this->user->addresses->first();
        $this->location = Location::where('pincode', $this->useraddress->pin)->first();
        return $next($request);
    });
  }


    public function getRate(Request $request)
    {
      
      $validatedData = $request->validate([
          'service' => 'bail|required|numeric',
          ]);

      //dd($request->all());
      $prices = ServicePrice::where(['location'=>$this->location->city, 
                                      'service_id'=>$request->input('service')])
                ->when($request->filled('search'), function($q) use($request){
                  $q->whereHas('item_details', function($q) use($request){
                    $q->where('name', 'like', '%'.$request->input('search').'%');
                  });
                })->where('service_type', '!=', 0)->paginate(5);            
      if (!$prices->total()) {
      	$prices = ServicePrice::where(['location'=>'global', 
                                      'service_id'=>$request->input('service')])
                                      ->when($request->filled('search'), function($q) use($request){
                                          $q->whereHas('item_details', function($q) use($request){
                                            $q->where('name', 'like', '%'.$request->input('search').'%');
                                          });
                                      })->where('service_type', '!=', 0)->paginate(5);
      }

      $search = $request->input('search');
      $type = $request->input('type');
      $edit = $prices->count();
      if ($request->ajax()) 
      {
        return view("store.rate-card.rates-table", compact('type', 'prices', 'edit', 'search'));
      }
      return response()->json(["message"=>"Data Recieved", 'prices'=>view("store.rate-card.rates-table",
                            compact('type', 'prices', 'edit'))->render()], 200);
    }

    public function index(Request $request)
    {
      
    	$services = Service::where(['type'=>1, 'status'=>1])->get();
    	$types = [1=>"Dry Clean", 2=>"Laundary", 3=>'Car Clean', 4=>'Shoe Clean', 5=>'Sofa Clean', 6=>'Home Clean'];
    	return view("store.rate-card.index", compact('services', 'types')) ;
    }

      public function getServices(Request $request)
    {
      $service = Service::where('form_type', $request->type)->where('type', 1)->pluck('name', 'id');
      return response()->json(["message"=>"Data Recieved", 'service'=>$service], 200);
    }

    // public function getRate(Request $request)
    // {
      
    //   $validatedData = $request->validate([
    //       'search' => 'bail|required|numeric',
    //       ]);

    //   $prices = ServicePrice::where(['location'=>$this->location->city, 
    //                                   'service_id'=>$request->input('service')])->where('service_type', '!=', 0)->paginate(5);            
    //   if (!$prices->total()) {
    //     $prices = ServicePrice::where(['location'=>'global', 
    //                                   'service_id'=>$request->input('service')])->where('service_type', '!=', 0)->paginate(5);
    //   }

    //   $type = $request->input('type');
    //   $edit = $prices->count();
    //   if ($request->ajax()) 
    //   {
    //     return view("store.rate-card.rates-table", compact('type', 'prices', 'edit'));
    //   }
    //   return response()->json(["message"=>"Data Recieved", 'prices'=>view("store.rate-card.rates-table",
    //                         compact('type', 'prices', 'edit'))->render()], 200);
    // }

}