<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Service;
use App\Model\ServicePrice;
use App\Model\BspLocation;
use App\Model\Location;
use App\Model\Items;
use DB;
use App\Http\Requests\Admin\StoreRateCard;
class RateCardController extends Controller
{
    public function getRateCard(Request $request)
    {
    	$activePage = "rate-card";
    	$titlePage = "Rate Card";
        $type = $request->input('type');
    	$cities = Location::groupBy('city_name')->selectRaw('city_name')->orderBy('city_name', 'asc')->pluck('city_name', 'city_name');

    	$cities['global']='Global';
    	
        $services = Service::orderBy('name', 'asc')->where('form_type', $request->input('type'))->where('type', 1)->pluck('name', 'id');
        $selected = null;
        if($request->input('type') != 2) {
            $selected = $services->keys()->first();
        }

        $prices = ServicePrice::where(['location'=>'global', 
                    'service_id'=>$selected])
                    ->get();
        $edit = $prices->count();
        $items = Items::where("type", $request->input('type'))->where('status', 1)->paginate(10);

    	if ($request->ajax()) 
        {
            if ($type==1) {
                //dd("type");
               return view('admin.rate-card.global-quantity', compact('city', 'items', 'prices', 'edit'));

            }
                return view('admin.rate-card.global-price', compact('city', 'items', 'prices', 'edit'));
        }

        return view('admin.rate-card.create', compact('activePage', 'titlePage', 'cities', 'services', 'items', 'type',
                                                        'selected', 'prices', 'edit'));
    }

    public function getRateCardForm(Request $request)
    {

        $validatedData = $request->validate([
          'city' => 'bail|required|string',
          'service' => 'bail|required|string',
          ]);

        $city =  $request->input('city');

        $items = Items::where("type", $request->input('type'))->where('status', 1)->paginate(10);
        
        $prices = ServicePrice::where(['location'=>$request->input('city'), 
                    'service_id'=>$request->input('service')])
                    ->paginate(5);
        $edit = $prices->count();

        $type = $request->input('type');

        if ($request->input('city')== 'global') 
    	{
            $type = $request->input('type');
           
            if ($type==1) {
               return view('admin.rate-card.global-quantity', compact('city', 'items', 'prices', 'edit'));

            }
            
            return view('admin.rate-card.global-price', compact('city', 'items', 'prices', 'edit'));
        }
    	
        return view('admin.rate-card.non-global', compact('city', 'items', 'prices', 'edit', 'type'));
    	
    }
    public function postRateCardForm(StoreRateCard $request)
    {

        try{
        DB::beginTransaction();

        $global_price = ServicePrice::where(['location'=>'global', 'service_id'=>$request->input('service')])->get();
        $insertData=[];
        if ($request->input('city')== 'global') 
        {
            foreach ($request->input('price') as $key => $value) {
                $data = ["service_id"=>$request->input('service'),                        
                         'parameter'=>$request->input('parameter')[$key],
                         'value'=>$value, 
                         'quantity'=> $request->input('quantity')[$key],
                         'service_type'=> $request->input('type'),
                         'location'=>$request->input('city')
                    ];
                array_push($insertData, $data);
                
                if ($global_price->count()) {
                    $services = ServicePrice::where('service_id', $request->input('service'))
                                ->where('location', '!=', 'global')->get();
                    if ($services->count()) {
                        foreach ($services as $key => $value) {

                            foreach ($request->price as $key => $inputprice) {
                                if ($request->parameter[$key]==$value->parameter) {
                                    
                                    if ($value->operator==1) 
                                    {
                                        $price = $inputprice + ($inputprice * ($value->bsp/100)); 
                                    }
                                    else
                                    {
                                            $price = $inputprice - ($inputprice * ($value->bsp/100));
                                    }

                                    ServicePrice::where(['id'=>$value->id])->update(['value'=>$price]);
                                }
                            }
                        }  
                    }
                }
            }
        }else{
            if ($global_price->count()==0) {
                return response()->json(["message"=>"Please provide global rates first !"], 200);
            }
            foreach ($global_price as $key => $value) {

                if ($request->input('operator')==1) 
                {
                    $price = $value->value + ($value->value * ($request->input('bsp')/100)); 
                }else
                {
                    //print_r($value->value);
                    $price = $value->value - ($value->value * ($request->input('bsp')/100));
                    //$price=0; 
                }
               array_push($insertData, [
                "location"=>$request->input('city'), "service_id"=>$request->input('service'), "quantity"=>$value->quantity, "service_id"=>$request->input('service'), "parameter"=>$value->parameter, "value"=>$price,'bsp'=> $request->input('bsp'), 'service_type'=> $request->input('type'),
                    'operator'=>$request->input('operator')]);
            }   
        }

        $delete = ServicePrice::where(['location'=>$request->input('city'),
                                      "service_id"=>$request->input('service')])->delete();
        $insert = ServicePrice::insert($insertData);
        
        DB::commit();
        return response()->json(["message"=>"Rate Card Successfully Inserted !", ], 200);
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(["message"=>$e->getMessage()], 400);
        }
    }

    public function getBlankExcel(Request $request)
    {
        $file_path = public_path('excel/demo.xlsx');
        return response()->download($file_path);
    }
}
