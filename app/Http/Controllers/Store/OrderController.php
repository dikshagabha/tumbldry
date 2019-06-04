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
    UserPayments,
    SMSTemplate

};
use App\User;
use Session;
use DB;
use PDF;
use App;
use App\Repositories\CommonRepository;
use App\Jobs\sendMessage;
class OrderController extends Controller
{
	protected $user;
  protected $useraddress;
  protected $location;
  protected $gst;
  protected $cgst;

	public function __construct(){
    $this->middleware(function($request, $next) {
        $this->user = Auth::user()->load('addresses', 'gst');
        $this->useraddress = $this->user->addresses->first();
        $this->location = Location::where('pincode', $this->useraddress->pin)->first();
        $this->gst = 9;
        $this->cgst = 9;
        
        if ($this->user->gst) {
          $this->gst = 0;
          $this->cgst = 0;
          if ($this->user->gst->enabled) {
            $this->gst = $user->gst->gst;
            $this->cgst = $user->gst->cgst;
          }
        }
        //dd($this->gst);
        return $next($request);
    });
  }

  public function index(Request $request){
    $activePage="order";
    $titlePage="Orders";
    $users = Order::where('store_id', $this->user->id)->with('items')->latest()->paginate(10);
    $runner = User::where('user_id', $this->user->id)->where('role', 5)->pluck('name', 'id');
    if ($request->ajax()) {
      return view('store.manage-order.list', compact('users', 'runner'));
    }
    return view('store.manage-order.index', compact('users', 'activePage', 'titlePage', 'runner'));
  }

  public function status(Request $request, $id){
    $activePage="order";
    $titlePage="Orders";

    try{
        $order = Order::where('id', $id)->with('customer')->first();
        $order->status = $request->input('status');
        

        //dd($order->customer->phone_number);
        if ($order) {
          if ($request->input('status')==2) {

            $customer = $order->customer;
            //dd($customer);
            if ($customer->phone_number) {
              //CommonRepository::sendmessage($customer->phone_number, 'Your%20order%20ORDER'.$id.'%20has%20been%20recieved%20by%20store.');

              $updateitems = OrderItems::where('order_id', $id)->update(['status'=>3]);
              $date = Carbon::now($request->header('timezone'));
              $order->date_of_arrival = $date;
            }
            
          }

          $order->save();
          return response()->json(['message'=>'Order Status Updated'], 200);
        }
    }catch(Exception $e)
    {
      return response()->json(['message'=>'Something went wrong'], 400);
    }

  }

  public function assignDelivery(Request $request, $id){
   
   $validatedData = $request->validate([
      'id'=>'bail|required|numeric|min:1']);
    try {
      DB::beginTransaction();
      $order = Order::where('id', $id)->with(['items'=>function($q){
        $q->with('itemimage');
      }])->first();
      $items = $order->items;
      if($items->where('status', 2)->count()==0) {
        return response()->json(['message'=>'The items have not been processed'], 400);
      }

      $status = 5;
      if ($items->where('status', 1)->count()) {
        $status=4;
      }
      $order->delivery_runner_id= $request->input('id');
      $order->status= $status;
      $order->save();

      $job = UserJobs::create(['user_id'=>$request->input('id'), 'order_id'=>$id, 'type'=>2, 'assigned_by'=>$this->user->id]);

      $runner = User::where('id', $request->input('id'))->first();
      if ($runner->phone_number) {
        
       // CommonRepository::sendmessage($runner->phone_number, 'Delivery%20of%20order%20id%20ORDER'.$id.'%20has%20been%20requested%20by'.$this->user->store_name);
      }
      DB::commit();
      
      $user = $this->user;
      

      $total = $items->sum('quantity');
      $weight = $items->sum('weight');
      $items_partial = $items->where('status', 2)->count();

      $pdf = PDF::loadView('store.manage-order.invoice', compact('order', 'user', 'items', 'total', 'weight','items_partial'));
      return ($pdf->download('invoice.pdf'));

      //return response()->json(['message'=>'Order Updated'], 200);
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
     $units=false;
     $weight=1;
    }else{
    $units=true;
    $weight=0;
    $form_id = Items::where('status', 1)->where('type', $Service->form_type)->first();
    }
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
    //dd($form_id->id);
    $price = $price->value;

    if ($Service->form_type == 2 ) {
      $units = true;
    }

    $addon = Service::where("form_type", $Service->form_type)->where('type', 2)->select('id', 'name')->get();
    
    $selected = [];
    if ($Service->selected == 1) {
     $selected = $addon->pluck('id')->toArray();
    }
    
    $data = ['service_id'=>$request->input('service'), 'item_id'=>$form_id->id, 'service_name'=>$Service->name, 'units'=>$units, 'addons'=> $addon, 'estimated_price'=>$price, 'item'=>$request->input('item'), 'price'=>$price, 'quantity'=>1, 'selected_addons'=>$selected , 'addon_estimated_price'=>0, 'weight'=>null];

     
     if (!session()->get('add_order_items')){
          $data['units']=$units;
          $data['weight']=$weight;
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

    $cgst = $total_price*($this->cgst/100);
    $gst = $total_price*($this->gst/100);

    $coupon_discount = 0;
    if (!session()->get('coupon_discount')) {
      session()->put("coupon_discount", ['coupon'=>'', 'discount'=>0, 'user_discount'=>null]);
    }else{
      $coupon_discount = session('coupon_discount');
    }


    $price_data = ['estimated_price'=> $total_price, 'cgst'=>$cgst, 'gst'=>$gst, 
                    'total_price'=>$total_price+$cgst+$gst-($coupon_discount['discount']+$coupon_discount['user_discount'])];

    session()->put('prices', $price_data);
    //dd($items);
    $wallet = session()->get('customer_details');
    return response()->json(['message'=>'Item Added to Cart', 'view'=>view('store.manage-order.items-view', compact('items', 'Service', 'form_id', 'price_data', 'coupon_discount', 'wallet'))->render(), 'items'=>$items,
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
    $cgst = $total_price*($this->cgst/100);
    $gst = $total_price*($this->gst/100);

    $coupon_discount = 0;
    if (!session()->get('coupon_discount')) {
      session()->put("coupon_discount", ['coupon'=>'', 'discount'=>0]);
    }else{
      $coupon_discount = session('coupon_discount');
    }

    $price_data = ['estimated_price'=> $total_price, 'cgst'=>$cgst, 'gst'=>$gst, 
                    'total_price'=>$total_price+$cgst+$gst-$coupon_discount['discount']];
    session()->put('prices', $price_data);
    $wallet = session()->get('customer_details');
    return response()->json(['message'=>'Item Deleted', 'view'=>view('store.manage-order.items-view', compact('items','price_data', 'coupon_discount', 'wallet'))->render(), 'items'=>$items], 200);
  }

  
  public function quantityItemSession(Request $request){
    $validatedData = $request->validate([
      'quantity'=>'bail|required|numeric|min:0|max:200']);

    $items = session('add_order_items');
    $index = $request->input('data-id')-1;
    
    $items[$index]['quantity'] =  $request->input('quantity');
    $form_type = Service::where('id', $request->input('service'))->first();

    if ($form_type->form_type!=2) {
      $items[$index]['estimated_price'] = ($request->input('quantity')*($items[$index]['price']));
    }

    if ($request->input('add')) {
      $items[$index]['estimated_price'] = $items[$index]['estimated_price'] +
                                        $items[$index]['addon_estimated_price'];
    }

    //dd($items[$index]);
    session()->put("add_order_items", $items);

    $items = session('add_order_items');
    $total_price = 0;
     foreach ($items as $key => $value) {
       if ($value) {
         $total_price = $total_price + $value['estimated_price'];
       }
     }

    $cgst = $total_price*($this->cgst/100);
    $gst = $total_price*($this->gst/100);
    $coupon_discount = 0;
    $coupon_discount = 0;
    if (!session()->get('coupon_discount')) {
      session()->put("coupon_discount", ['coupon'=>null, 'discount'=>null, 'user_discount'=> null]);
    }else{
      $coupon_discount = session('coupon_discount');
    }
    $price_data = ['estimated_price'=> $total_price, 'cgst'=>$cgst, 'gst'=>$gst,
                                'total_price'=>$total_price+$cgst+$gst-($coupon_discount['discount']+$coupon_discount['user_discount'])];
    session()->put('prices', $price_data);
    $wallet = session()->get('customer_details');
    return response()->json(['message'=>'Item Updated', 'view'=>view('store.manage-order.items-view', compact('items','price_data', 'coupon_discount', 'wallet'))->render(), 'items'=>$items], 200);
  }

  public function weightItemSession(Request $request){
    $validatedData = $request->validate([
      'weight'=>'bail|required|numeric|min:0|max:200']);

    $items = session('add_order_items');
    $index = $request->input('data-id')-1;
    
    $items[$index]['weight'] =  $request->input('weight');

    //dd( session('add_order_items'));
    $items[$index]['estimated_price'] = ($request->input('weight')*($items[$index]['price']))+
                                        $items[$index]['addon_estimated_price'];
    session()->put("add_order_items", $items);

    $items = session('add_order_items');
    $total_price = 0;
    foreach ($items as $key => $value) {
       if ($value) {
         $total_price = $total_price + $value['estimated_price'];
       }
    }

    $cgst = $total_price*($this->cgst/100);
    $gst = $total_price*($this->gst/100);
    $coupon_discount = 0;
    
    if (!session()->get('coupon_discount')) {
      session()->put("coupon_discount", ['coupon'=>null, 'discount'=>null, 'user_discount'=> null]);
    }else{
      $coupon_discount = session('coupon_discount');
    }
    $price_data = ['estimated_price'=> $total_price, 'cgst'=>$cgst, 'gst'=>$gst,
                                'total_price'=>$total_price+$cgst+$gst-($coupon_discount['discount']+$coupon_discount['user_discount'])];
    session()->put('prices', $price_data);
    $wallet = session()->get('customer_details');
    return response()->json(['message'=>'Item Updated', 'view'=>view('store.manage-order.items-view', compact('items','price_data', 'coupon_discount', 'wallet'))->render(), 'items'=>$items], 200);
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

    $items[$index]['estimated_price'] =  ( $items[$index]['price'] * $request->input('weight') ) + $items[$index]['addon_estimated_price'];
  
    session()->put("add_order_items", $items);

    $items = session('add_order_items');
    $total_price = 0;
     foreach ($items as $key => $value) {
       if ($value) {
         $total_price = $total_price + $value['estimated_price'];
       }
     }

    $cgst = $total_price*($this->cgst/100);
    $gst = $total_price*($this->gst/100);
   
    $coupon_discount = 0;
    if (!session()->get('coupon_discount')) {
      session()->put("coupon_discount", ['coupon'=>null, 'discount'=>null, 'user_discount'=>null]);
    }else{
      $coupon_discount = session('coupon_discount');
    }
    $price_data = ['estimated_price'=> $total_price, 'cgst'=>$cgst, 'gst'=>$gst,
                                'total_price'=>$total_price+$cgst+$gst-($coupon_discount['discount']+$coupon_discount['user_discount'])];     
    

    session()->put('prices', $price_data);
    $wallet = session()->get('customer_details');

    return response()->json(['message'=>'Item Updated', 'view'=>view('store.manage-order.items-view', compact('items','price_data', 'coupon_discount', 'wallet'))->render(), 'items'=>$items], 200);
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

    $discount = $discount+session('coupon_discount')['user_discount'];
    
    $coupon_discount = ['discount'=>$discount, 'coupon'=>$coupon->coupon, 'user_discount'=>session('coupon_discount')['user_discount']];
    session()->put("coupon_discount", $coupon_discount);
    
    $cgst = $total_price*($this->cgst/100);
    $gst = $total_price*($this->gst/100);
    $price_data = ['estimated_price'=> $total_price, 'cgst'=>$cgst, 'gst'=>$gst, 
                                'total_price'=>$total_price+$cgst+$gst-$discount];
    session()->put('prices', $price_data);
    $wallet = session()->get('customer_details');
    return response()->json(['message'=>'Items Updated', 'view'=>view('store.manage-order.items-view', compact('items','price_data', 'coupon_discount', 'wallet'))->render(), 'items'=>$items], 200);
  }

  public function discountItemSession(Request $request){
    $validatedData = $request->validate([
      'discount'=>'bail|required|min:1|max:99999|numeric']);

  
    $items = session('add_order_items');
    
    $total_price = 0;
    foreach ($items as $key => $value) {
       if ($value) {
         $total_price = $total_price + $value['estimated_price'];
       }
    }


    $coupon_discount = session()->get('coupon_discount');    
    $cgst = $total_price*($this->cgst/100);
    $gst = $total_price*($this->gst/100);
    
    $total = $total_price+$cgst+$gst-$coupon_discount['discount'];


    if ($request->input('discount')>$total) 
    {
      return response()->json(['message'=>"Discount can not be greater than total price"], 400);
    }
    
    $coupon_discount['user_discount']=$request->input('discount');
    session()->put("coupon_discount", $coupon_discount);

    $discount = $coupon_discount['discount']+$coupon_discount['user_discount'];

    $price_data = ['estimated_price'=> $total_price, 'cgst'=>$cgst, 'gst'=>$gst, 
                                'total_price'=>$total_price+$cgst+$gst-$discount];
    session()->put('prices', $price_data);
    $wallet = session()->get('customer_details');
    return response()->json(['message'=>'Items Updated', 'view'=>view('store.manage-order.items-view', compact('items','price_data', 'coupon_discount', 'wallet'))->render(), 'items'=>$items], 200);
  }


  
  public function store(Request $request, $id=null){

   $user=$this->user;
    $validatedData = $request->validate(['delivery_mode'=>'bail|required|integer']);
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
      //dd(round($prices['total_price'], 2));
      $order = Order::create([ 'pickup_id'=>$id, 'customer_id'=>$customer_id, 
                               'address_id'=>$address_id,'runner_id'=>$assignedTo, 'store_id'=>$user->id,
                               'estimated_price'=>$prices['estimated_price'], 'cgst'=>$prices['cgst'],
                               'gst'=>$prices['gst'], 'total_price'=>round($prices['total_price'], 2),
                               'coupon_discount'=>$coupon_discount['discount'], 'coupon_id'=>$coupon_discount['coupon'],
                               'discount'=>$coupon_discount['user_discount'], 'service_id'=>$request->input('service'),
                               'delivery_mode'=>$request->input('delivery_mode')
                            ]);

      // $points = $order->total_price*40/100;
      // $insert = $points;
      
      // if($wallet->wallet->loyality_points)
      // {
      //   $insert = $wallet->wallet->loyality_points + $points;
      // }
      // if ($price > $order->total_price) {       
      //   $paymentData = [['order_id'=>$order->id,
      //                             'user_id'=>$customer_id,
      //                           'to_id'=>$this->user->id, 'type'=>1, 
      //                           'price'=>$order->total_price, 'created_at'=>Carbon::now()]];
        
      //   //UserWallet::where('user_id', $wallet->id)->update(['price'=>$price - $order->total_price, 
      //   //                                                 'loyality_points'=>$insert]);
      // }else{
      //   $paymentData = [['order_id'=>$order->id, 'to_id'=>$this->user->id, 'type'=>1, 
      //                   'user_id'=>$customer_id,'created_at'=>Carbon::now(),
      //                   'price'=>$price], ['order_id'=>$order->id, 
      //                     'user_id'=>$customer_id,'to_id'=>$this->user->id, 'type'=>2, 
      //                   'price'=>$order->total_price-$price,'created_at'=>Carbon::now()]];
      //   $amount = $order->total_price-$price;
        
      //   //UserWallet::where('user_id', $wallet->id)->update(['price'=>0, 
      //   //                                                  'loyality_points'=>$insert]);
      // }
      
      //array_push($paymentData, ['order_id'=>$order->id, 'to_id'=>$customer_id, 'created_at'=>Carbon::now(),
      //  'user_id'=>0,'type'=>3, 'price'=>$points]);
      //$payments = UserPayments::insert($paymentData);
      //$response = CommonRepository::sendmessage($wallet->phone_number, $message);

      foreach ($items as $item) {
          $item['order_id']=$order->id;
          $orderitem = OrderItems::create($item); 
          $itemData = [];
          foreach ($item['selected_addons'] as $key => $value) 
          {
            array_push($itemData, ['order_id'=>$order->id, 'item_id'=>$orderitem->id, 'addon_id'=>$value]);
          }
          $order_items = OrderItemImage::insert($itemData);
      }
      DB::commit();
      return response()->json([ 'redirectTo'=>route('store.paymentmodes', $order->id), 'message'=>'Order has been created Successfully'], 200); 
   } catch (Exception $e) {
      DB::rollback();
      return response()->json(['message'=>$e->getMessage()], 400);
   }
  } 
 
  public function view(Request $request, $id){
    $order = Order::where('id', $id)->with('items', 'customer', 'address', 'payment')->first();
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

    if (!$request->input('grn')) {
      return response()->json(['message'=> 'Please select an item'], 400);
    }
    $orders = OrderItems::whereIn('id', $request->input('grn'))->with('order')->with(['itemimage'=>function($q){
       $q->with('addons');
      }])->get();
     $user = $this->user;
     
     $update_status = OrderItems::whereIn("id", $request->input('grn'))->update(['status'=> 4]);
     $order_update = Order::where('id', $request->input('order_id'))->update(['status'=>3]);
     $pdf = PDF::loadView('store.grn.grn', compact('orders', 'user'));
     return ($pdf->download('invoice.pdf'));
  }


  public function markRecieved(Request $request, $id)
  {
    //dd($request->all());

    $status=1;
    if($request->input('status')==1) {
     $status=3;
    }
    $orders = OrderItems::where('id', $id)->update(['status'=> 3]);

    if($orders){
      return response()->json(['message'=> 'Items Updated'], 200);
    }
    return response()->json(['message'=> 'Something went Wrong'], 400);
    
  }

  public function itemsDeliver(Request $request)
  {
    if (!$request->input('deliver')) {
      return response()->json(['message'=> 'Please select an item'], 400);
    }

    $orders = OrderItems::whereIn('id', $request->input('deliver'))->update(['status'=>2]);

    if ($orders) {
      return response()->json(['message'=> 'Items Updated'], 200);
    }
    return response()->json(['message'=> 'Something went Wrong'], 400);
  }

  public function setServiceInput(Request $request){
    session()->forget('add_order_items');
    session()->forget('prices');
    session()->forget('coupon_discount');
    $type = Service::where('id', $request->input('id'))->select('form_type')->first();
    $form_type = $type->form_type;
    $data = Items::where('type', $type->form_type)->pluck('name', 'name');

    return response()->json(['view'=>view('store.manage-order.input', compact('type', 'data'))->render(), 'form_type'=>$form_type]);

  }

  public function invoice(Request $request, $id){

    //$id = $request->input('id');
    $order = Order::where('id', $id)->with(['items'=>function($q){
        $q->with('itemimage');
      }])->first();
     $items = $order->items;
     $user = $this->user;
    $total = $items->sum('quantity');
    $weight = $items->sum('weight');
    $items_partial = $items->where('status', 1);
    //dd($items_partial);
    if (! $items->where('status', 2)->count()) {
      return response()->json(['message'=>"No items processed yet."], 400);
    }
    $pdf = PDF::loadView('store.manage-order.invoice', compact('order', 'user', 'items', 'total', 'weight','items_partial'));
    return ($pdf->download('invoice.pdf'));

  }
}
