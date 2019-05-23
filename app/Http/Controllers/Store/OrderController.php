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
    OrderItemImage,
    Location,
    ServicePrice,
    Coupon,
    UserJobs,
    Address,
    LaundaryWeights,
    UserWallet,
    UserPayments

};
use App\User;
use Session;
use DB;
use PDF;
use App;
use App\Repositories\CommonRepository;
class OrderController extends Controller
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

  public function index(Request $request){
    $activePage="order";
    $titlePage="Orders";
    $users = Order::where('store_id', $this->user->id)->latest()->paginate(10);
    $runner = User::where('user_id', $this->user->id)->pluck('name', 'id');
    if ($request->ajax()) {
      return view('store.manage-order.list', compact('users', 'runner'));
    }
    return view('store.manage-order.index', compact('users', 'activePage', 'titlePage', 'runner'));
  }

  public function status(Request $request, $id){
    $activePage="order";
    $titlePage="Orders";
    $order = Order::where('id', $id)->with('customer')->first();
    $order->status = $request->input('status');
    

    //dd($order->customer->phone_number);
    if ($order) {
      if ($request->input('status')==2) {
        $customer = $order->customer;
        //dd($customer);
        if ($customer->phone_number) {
          //CommonRepository::sendmessage($customer->phone_number, 'Your%20order%20ORDER'.$id.'%20has%20been%20recieved%20by%20store.');

          $date = Carbon::now($request->header('timezone'));
          $order->date_of_arrival = $date;
        }
        
      }

      $order->save();
      return response()->json(['message'=>'Order Status Updated'], 200);
    }
  }

  public function assignDelivery(Request $request, $id){
   
   $validatedData = $request->validate([
      'id'=>'bail|required|numeric|min:1']);

    try {
      DB::beginTransaction();
      $order = Order::where('id', $id)->first();
      $order->delivery_runner_id= $request->input('id');
      $order->save();

      $job = UserJobs::create(['user_id'=>$request->input('id'), 'order_id'=>$id, 'type'=>2, 'assigned_by'=>$this->user->id]);

      $runner = User::where('id', $request->input('id'))->first();
      if ($runner->phone_number) {
        CommonRepository::sendmessage($runner->phone_number, 'Delivery%20of%20order%20id%20ORDER'.$id.'%20has%20been%20requested%20by'.$this->user->store_name);
      }
      DB::commit();
      return response()->json(['message'=>'Order Updated'], 200);
    } catch (Exception $e) {
      return response()->json(['message'=>'Something went wrong'], 400);
    }   
  }

  public function create(Request $Request, $id){

  	$activePage="dashboard";
  	$titlePage="Create Order";
  	session()->forget('add_order_items');
    session()->forget('prices');
    session()->forget('coupon_discount');

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
  	$type = Service::where('id', $request->input('service'))->select('form_type')->first();
	  $data = Items::where("name","LIKE","%{$request->input('query')}%")
            ->where('type', $type->form_type)->pluck('name');
	  //$data = Items::where('type', $type->form_type)->pluck('name');
    return response()->json($data);    	
  }

  public function addItemSession(Request $request){
    $validatedData = $request->validate([
    'service'=>'bail|required|numeric|min:1',
     'item'=>'bail|required|string|min:1|max:500']);

    $Service = Service::where("id", $request->input('service'))->first();

    if ($Service->form_type !=2) {
     $form_id = Items::where("name", 'LIKE','%'.$request->input('item').'%' )->where('type', $Service->form_type)->first();
    }else{
    $form_id = Items::where('status', 1)->where('type', $Service->form_type)->first();
    }

    //dd($this->location);
    //print_r($Service);
    if (!$form_id) {
       return response()->json(['message'=>'We donot have details for this item.'], 400);
    }

    if ($Service->form_type ==2 ) {
      $form_id = Items::where('type', 2)->first();
    }

    $price = ServicePrice::where(['service_id'=>$Service->id])->where('parameter', $form_id->id)
            ->where('location', 'LIKE', '%'.$this->location->city_name.'%')->first();

    $units = false;
    if (!$price) {
     $price = ServicePrice::where(['service_id'=>$Service->id])->where('parameter', $form_id->id)
              ->where('location', 'global')->first();
    }
    
    if ($Service->form_type !=2 ) {
       if ($price) {
          $price = $price->value;
         }
    }else{
        //$form_id = Items::where("name", 'LIKE','% Laundary %' )->where('type', $Service->form_type)->first();
        
        // $weight = LaundaryWeights::where('item_id', $form_id->id)->first();
        // if ($weight->weight_unit==2) {
        //   $weight = $weight->weight/1000;
        // }else{
        //   $weight=$weight->weight;
        // }

      $price = $price->value;
      $units = true;
    }

    $addon = Service::where("form_type", $Service->form_type)->where('type', 2)->select('id', 'name')->get();
    
    $selected = [];
    if ($Service->selected == 1) {
     $selected = $addon->pluck('id')->toArray();
    }
    
    $data = ['service_id'=>$request->input('service'), 'item_id'=>$form_id->id, 'service_name'=>$Service->name, 'units'=>$units, 'addons'=> $addon, 'estimated_price'=>$price, 'item'=>$request->input('item'), 'price'=>$price, 'quantity'=>1, 'selected_addons'=>$selected , 'addon_estimated_price'=>0];

     
     if (!session()->get('add_order_items')){

          session()->put("add_order_items", [$data]);            
     }
     else{session()->push('add_order_items', $data);}

     $items = session('add_order_items');
     $total_price = 0;
     foreach ($items as $key => $value) {
       if ($value) {
         $total_price = $total_price + $value['addon_estimated_price']+$value['estimated_price'];
       }
     }
    $cgst = $total_price*(9/100);
    $gst = $total_price*(9/100);

    $coupon_discount = 0;
    if (!session()->get('coupon_discount')) {
      session()->put("coupon_discount", ['coupon'=>'', 'discount'=>0]);
    }else{
      $coupon_discount = session('coupon_discount');
    }

    $price_data = ['estimated_price'=> $total_price, 'cgst'=>$cgst, 'gst'=>$gst,
                    'total_price'=>$total_price+$cgst+$gst-$coupon_discount['discount']];

    session()->put('prices', $price_data);
    //dd($items);

    return response()->json(['message'=>'Item Added to Cart', 'view'=>view('store.manage-order.items-view', compact('items', 'Service', 'form_id', 'price_data', 'coupon_discount'))->render(), 'items'=>$items,
        'price_data'=>$price_data], 200);
  }

  public function deleteItemSession(Request $request){

    $items = session('add_order_items');
    //dd($items);
    $index = $request->input('data-id')-1;
    unset($items[$index]);

    $items = array_values($items);

    //dd($items);
    session()->put("add_order_items", $items);

    $items = session('add_order_items');
    $total_price = 0;
     foreach ($items as $key => $value) {
       if ($value) {
         $total_price = $total_price + $value['estimated_price'];
       }
     }
    $cgst = $total_price*(9/100);
    $gst = $total_price*(9/100);

    $coupon_discount = 0;
    if (!session()->get('coupon_discount')) {
      session()->put("coupon_discount", ['coupon'=>'', 'discount'=>0]);
    }else{
      $coupon_discount = session('coupon_discount');
    }

    $price_data = ['estimated_price'=> $total_price, 'cgst'=>$cgst, 'gst'=>$gst, 
                    'total_price'=>$total_price+$cgst+$gst-$coupon_discount['discount']];
    session()->put('prices', $price_data);
    
    return response()->json(['message'=>'Item Deleted', 'view'=>view('store.manage-order.items-view', compact('items','price_data', 'coupon_discount'))->render(), 'items'=>$items], 200);
  }

  
  public function quantityItemSession(Request $request){
    $validatedData = $request->validate([
      'quantity'=>'bail|required|numeric|min:0|max:200']);

    $items = session('add_order_items');
    $index = $request->input('data-id')-1;
    
    $items[$index]['quantity'] =  $request->input('quantity');
    $items[$index]['estimated_price'] = ($request->input('quantity')*($items[$index]['price']))+
                                        $items[$index]['addon_estimated_price'];
    //unset($items[$index]);


    session()->put("add_order_items", $items);

    $items = session('add_order_items');
    $total_price = 0;
     foreach ($items as $key => $value) {
       if ($value) {
         $total_price = $total_price + $value['estimated_price'];
       }
     }

    $cgst = $total_price*(9/100);
    $gst = $total_price*(9/100);
    $coupon_discount = 0;
    $coupon_discount = 0;
    if (!session()->get('coupon_discount')) {
      session()->put("coupon_discount", ['coupon'=>null, 'discount'=>null]);
    }else{
      $coupon_discount = session('coupon_discount');
    }
    $price_data = ['estimated_price'=> $total_price, 'cgst'=>$cgst, 'gst'=>$gst,
                                'total_price'=>$total_price+$cgst+$gst-$coupon_discount['discount']];     
    

    session()->put('prices', $price_data);
    
    return response()->json(['message'=>'Item Updated', 'view'=>view('store.manage-order.items-view', compact('items','price_data', 'coupon_discount'))->render(), 'items'=>$items], 200);
  }


  public function addonItemSession(Request $request){

    $validatedData = $request->validate([
        'addon'.$request->input('id')=>['bail','required', 'array', 'min:1', 'max:100']
      ]);

    $items = session('add_order_items');
    $index = $request->input('id')-1;
    $addons_input = $request->input('addon'.$request->input('id'));
    $items[$index]['selected_addons'] =  $addons_input;

    // Price of addons
    $prices = ServicePrice::where('service_id', $request->input('service'))->whereIn('parameter', 
                $addons_input)->where('service_type', 0)
              ->where('location','like' ,'%'.$this->location->city_name.'%')->sum('value');
    if(!$prices){
      $prices = ServicePrice::where('service_id', $request->input('service'))
                ->whereIn('parameter', $addons_input)
              ->where('location','like' , 'global')->where('service_type', 0)->sum('value');
    }
    
   
    if(Service::where(['id'=>$request->input('service'), 'selected'=>1])->count()){
    	$prices = 0;
    	}
    $items[$index]['addon_estimated_price'] = $prices;

    $items[$index]['estimated_price'] =  ( $items[$index]['price'] * $request->input('quantity') ) + $items[$index]['addon_estimated_price'];
  
    session()->put("add_order_items", $items);

    $items = session('add_order_items');
    $total_price = 0;
     foreach ($items as $key => $value) {
       if ($value) {
         $total_price = $total_price + $value['estimated_price'];
       }
     }

    $cgst = $total_price*(9/100);
    $gst = $total_price*(9/100);
    $coupon_discount = 0;
    $coupon_discount = 0;
    if (!session()->get('coupon_discount')) {
      session()->put("coupon_discount", ['coupon'=>null, 'discount'=>null]);
    }else{
      $coupon_discount = session('coupon_discount');
    }
    $price_data = ['estimated_price'=> $total_price, 'cgst'=>$cgst, 'gst'=>$gst,
                                'total_price'=>$total_price+$cgst+$gst-$coupon_discount['discount']];     
    

    session()->put('prices', $price_data);
    
    return response()->json(['message'=>'Item Updated', 'view'=>view('store.manage-order.items-view', compact('items','price_data', 'coupon_discount'))->render(), 'items'=>$items], 200);
  }

  public function couponItemSession(Request $request){
    $validatedData = $request->validate([
      'coupon'=>'bail|required|min:1|max:20|string']);

    if (session('coupon_discount')['discount']>0) {
      return response()->json(['message'=>'A coupon has already been aplied'], 400);
    }

    
    $coupon = Coupon::where('coupon', 'like','%'.$request->input('coupon').'%')->where('status', 1)->first();
    if (!$coupon) {
     return response()->json(['message'=>'Invalid Coupon'], 400);
    }


    $items = session('add_order_items');
    
    $total_price = 0;
     foreach ($items as $key => $value) {
       if ($value) {
         $total_price = $total_price + $value['estimated_price'];
       }
     }
    if ($coupon->coupon_price) {
      $discount = $coupon->coupon_price;
    }
    else{
      $discount = ($coupon->coupon_percent*$total_price/100);
    }
    
    $coupon_discount = ['discount'=>$discount, 'coupon'=>$coupon->coupon];
    session()->put("coupon_discount", $coupon_discount);
    
    $cgst = $total_price*(9/100);
    $gst = $total_price*(9/100);
    $price_data = ['estimated_price'=> $total_price, 'cgst'=>$cgst, 'gst'=>$gst, 
                                'total_price'=>$total_price+$cgst+$gst-$discount];
    session()->put('prices', $price_data);

    return response()->json(['message'=>'Items Updated', 'view'=>view('store.manage-order.items-view', compact('items','price_data', 'coupon_discount'))->render(), 'items'=>$items], 200);
  }


  
  public function store(Request $request, $id=null){

   $user=$this->user;

   if ($id) {
     $id = decrypt($id);     
     $pickup = PickupRequest::where("id", $id)->first();
     $customer_id=$pickup->customer_id;
     $address_id = $pickup->address_id;
     $assignedTo = $pickup->assignedTo;

     if (!$pickup) {
           return response()->json(['message'=>'Something Went Wrong'], 400);
     }
   }else{
    // Create Customer
    $assignedTo = null;
    if ($request->input('customer_id')) 
    {
      $customer_id = $request->input('customer_id');
      $address_id = $request->input('address_id');

    }else{

      $validatedData = $request->validate([
        'name'=>['bail','required', 'string', 'min:2', 'max:100'],
        'phone_number'=>['bail','required','numeric', 'unique:users,phone_number,'.$id, 'min:2', 'max:9999999999']
      ]);

      $user = User::create(['name'=>$request->input('name'), 
                      'email'=>$request->input('email'),
                      'phone_number'=>$request->input('phone_number'),  
                      'role'=> 4
                      ]);

      if (!session()->get('address')) {
        return response()->json(['errors'=>
                                  ['address_id'=>['Please enter customer address.']]], 422);
      }
      $address = Address::create(session()->get('address'));
      $customer_id = $user->id;
      $address_id = $address->id;
    }
   }    

   $items = session()->get('add_order_items');
   $prices = session()->get('prices');
   $coupon_discount = session()->get('coupon_discount');
   if (!$items) {
         return response()->json(['message'=>'The items are not included in order.'], 400);
   }
   try {
      DB::beginTransaction();


      $wallet = User::where('id', $request->input('customer_id'))->with('wallet')->first();
      $price=0;
      if ($wallet->wallet && $wallet->wallet->count()) {
        $price = $wallet->wallet->first()->price;
      }

      $order = Order::create([ 'pickup_id'=>$id, 'customer_id'=>$customer_id, 
                               'address_id'=>$address_id,'runner_id'=>$assignedTo, 'store_id'=>$user->id,
                               'estimated_price'=>$prices['estimated_price'], 'cgst'=>$prices['cgst'],
                               'gst'=>$prices['gst'], 'total_price'=>round($prices['total_price'], 2),
                               'coupon_discount'=>$coupon_discount['discount'], 'coupon_id'=>$coupon_discount['coupon'],
                            ]);
      
      
      $points = $order->total_price*40/100;
      $insert = $points;
      
      if($wallet->wallet->loyality_points)
      {
        $insert = $wallet->wallet->loyality_points + $points;
      }

      if ($price > $order->total_price) {       
        $paymentData = ['order_id'=>$order->id,
                          'user_id'=>$customer_id,
                        'to_id'=>$this->user->id, 'type'=>1, 
                        'price'=>$order->total_price];
        $message = "$order->total_price%20Rs%20has%20been%20deducted%20from%20your%20wallet%20for%20ORDER$order->id.";
        
        UserWallet::where('user_id', $wallet->id)->update(['price'=>$price - $order->total_price]);
      }else{
        $paymentData = [['order_id'=>$order->id, 'to_id'=>$this->user->id, 'type'=>1, 
                        'user_id'=>$customer_id,
                        'price'=>$price], ['order_id'=>$order->id, 
                          'user_id'=>$customer_id,'to_id'=>$this->user->id, 'type'=>2, 
                        'price'=>$order->total_price-$price]];
        $amount = $order->total_price-$price;
        $message = "$price%20Rs%20has%20been%20deducted%20from%20your%20wallet%20and%20you%20have%20to%20pay%20$amount%20more%20for%20ORDER$order->id.";
        UserWallet::where('user_id', $wallet->id)->update(['price'=>0]);
      }
       
      $payments = UserPayments::insert($paymentData);

      $response = CommonRepository::sendmessage($wallet->phone_number, $message);

      foreach ($items as $item) {
          $item['order_id']=$order->id;
          $orderitem = OrderItems::create($item); 
          $itemData = [];
          foreach ($item['selected_addons'] as $key => $value) 
          {
            array_push($itemData, ['order_id'=>$order->id, 'item_id'=>$orderitem->id, 'addon_id'=>$value]);
          }
          $item = OrderItemImage::insert($itemData);
      }
      DB::commit();
      return response()->json([ 'redirectTo'=>route('store.home'), 'message'=>'Order has been created Successfully'], 200); 
   } catch (Exception $e) {
      DB::rollback();
      return response()->json(['message'=>$e->getMessage()], 400);
   }
  }

  public function view(Request $request, $id){
    $order = Order::where('id', $id)->with('items', 'customer', 'address')->first();
    return view('store.manage-order.show', compact('order'));
  }

  public function createWithoutPickup(Request $request){
    $activePage="order";
    $titlePage="Create Order";
    session()->forget('add_order_items');
    session()->forget('prices');
    session()->forget('coupon_discount');

    $services = Service::where(['status'=>1])->get();
    $add_on = $services->where('type', 2)->pluck('name', 'id');
    $services = $services->where('type', 1)->pluck('name', 'id');
    

    return view("store.manage-order.create-without-pickup", compact('services', 'activePage', 'titlePage', 'add_on', 'id', 'pickup'));

  }

  public function getGrn(Request $request)
  {
   $orders = OrderItems::whereIn('id', $request->input('grn'))->with('order')->with(['itemimage'=>function($q){
       $q->with('addons');
      }])->get();
  
   $pdf = PDF::loadView('store.grn.grn', compact('orders'));
   return ($pdf->download('invoice.pdf'));
  }
}
