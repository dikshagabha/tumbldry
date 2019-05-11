<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Notification;
use App\Http\Requests\Store\LoginRequest;
use Carbon\Carbon;

use App\Model\{
	Items,
	Service,
    PickupRequest,
    OrderItems,
    Order,
    OrderItemImage
};
use Session;
use DB;
class OrderController extends Controller
{
	protected $user;
	public function __construct(){

        // if the user is logged in then fetches the details of the user
        $this->middleware(function($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
	}

    public function create(Request $Request, $id){

    	$activePage="dashboard";
    	$titlePage="Create Order";
    	session()->forget('add_order_items');
    	$services = Service::where(['status'=>1])->get();
    	$add_on = $services->where('type', 2)->pluck('name', 'id');
    	$services = $services->where('type', 1)->pluck('name', 'id');
        $pickup = PickupRequest::where("id", decrypt($id))->first();
        if (!$pickup) {
            return redirect()->route('store.home');
        }
        
    	return view("store.manage-order.create", compact('services', 'activePage', 'titlePage', 'add_on', 'id', 'pickup'));
    }

    public function getItems(Request $request){
    	//$type = Service::where('id', $request->input('type'))->select('form_type')->first();
		$data = Items::where("name","LIKE","%{$request->input('query')}%")->pluck('name');
		//$data = Items::where('type', $type->form_type)->pluck('name');
	    
	    return response()->json($data);    	
    }

    public function addItemSession(Request $request){

       $Service = Service::where("id", $request->input('service'))->first();
       $form_id = Items::where("name", 'LIKE', $request->input('name'))->where('type', $Service->form_type)->first();
       
       
       if (!$form_id) {
           return response()->json(['message'=>'The item is not included in service.'], 400);
       }
	   
       $images=array();

       if($files=$request->file('images')){
        foreach($files as $file){
                $name= time().$file->getClientOriginalName();
                $file->move(public_path().'/uploaded_images/order', $name);
                $images[]=$name;
            }
        }
        //session()->forget('add_order_items');
       $data = ['service_id'=>$request->input('service'), 'item_id'=>$form_id->id, 
                                                                       'quantity'=>$request->input('quantity'), 
                                                                        'images'=>$images,
                'service_name'=>$Service->name, 'item'=>$form_id->name];
       if (!session()->get('add_order_items')){

            session()->put("add_order_items", [$data]);            
       }
       else{session()->push('add_order_items', $data);}

       $items = session('add_order_items');
       return response()->json(['message'=>'Item Saved', 'view'=>view('store.manage-order.items-view', compact('items', 'Service', 'form_id'))->render(), 'items'=>$items], 200);
    }

    public function deleteItemSession(Request $request){

      $items = session('add_order_items');
      $index = $request->input('data-id')-1;
      unset($items[$index]);


      session()->put("add_order_items", $items);

      $items = session('add_order_items');

      return response()->json(['message'=>'Item Deleted', 'view'=>view('store.manage-order.items-view', compact('items'))->render(), 'items'=>$items], 200);
    }

    public function store(Request $request, $id){

     $id = decrypt($id);
     
     $pickup = PickupRequest::where("id", $id)->first();
     
     if (!$pickup) {
           return response()->json(['message'=>'Something Went Wrong'], 400);
     }
     $items = session()->get('add_order_items');

     if (!$items) {
           return response()->json(['message'=>'The items are not included in order.'], 400);
     }

     $user=$this->user;
     try {
        DB::beginTransaction();
        $order = Order::create(['pickup_id'=>$id, 'customer_id'=>$pickup->customer_id, 
                                    'address_id'=>$pickup->address_id,'runner_id'=>$pickup->assignedTo, 'store_id'=>$user->id]);
       
        foreach ($items as $item) {
            $item['order_id']=$order->id;
            $orderitem = OrderItems::create($item);
            $images = [];
            
            foreach ($item['images'] as $key => $value) {
                array_push($images, ['order_id'=>$order->id, 'item_id'=>$orderitem->id, 'image'=>$value]);
            }
            
            $image = OrderItemImage::insert( $images);            
        }
        DB::commit();
        return response()->json(['message'=>'Order Created'], 200);
         
     } catch (Exception $e) {
        DB::rollback();
         return response()->json(['message'=>$e->getMessage()], 400);
     }
    }

}
