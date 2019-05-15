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
    Address
};
use App\User;
use Session;
use DB;
class OrderController extends Controller
{
	protected $user;
  protected $useraddress;
  protected $location;

	public function __construct(){

        // if the user is logged in then fetches the details of the user
      $this->middleware(function($request, $next) {
          $this->user = Auth::user()->load('addresses');
          $this->useraddress = $this->user->addresses->first();

          $this->location = Location::where('pincode', $this->useraddress->pin)->first();
          //dd($location);

          return $next($request);
      });
  }

  public function index(Request $request){
    $activePage="order";
    $titlePage="Orders";
    $users = Order::where('store_id', $this->user->id)->paginate(10);

    if ($request->ajax()) {
      return view('store.manage-order.list', compact('users'));
    }
    return view('store.manage-order.index', compact('users', 'activePage', 'titlePage'));
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
  	//$type = Service::where('id', $request->input('type'))->select('form_type')->first();
	  $data = Items::where("name","LIKE","%{$request->input('query')}%")->pluck('name');
	  //$data = Items::where('type', $type->form_type)->pluck('name');
    return response()->json($data);    	
  }

  public function addItemSession(Request $request){
     $validatedData = $request->validate([
      'service'=>'bail|required|numeric|min:1']);

     $Service = Service::where("id", $request->input('service'))->first();
     $form_id = Items::where("name", 'LIKE','%'.$request->input('item').'%' )->where('type', $Service->form_type)->first();
     //dd($form_id);
     if (!$form_id) {
         return response()->json(['message'=>'We donot have details for this item.'], 400);
     }

     $price = ServicePrice::where(['parameter'=>$form_id->id, 'service_id'=>$Service->id])->where('location', $this->location->id)->first();
     
     if (!$price) {
       $price = ServicePrice::where(['parameter'=>$form_id->id, 'service_id'=>$Service->id])->where('location', 'global')->first();
     }

     if ($price) {
      $price = $price->value;
     }

     
     $data = ['service_id'=>$request->input('service'), 'item_id'=>$form_id->id, 'service_name'=>$Service->name,
              'item'=>$form_id->name, 'price'=>$price, 'quantity'=>1];
     $data['estimated_price']=$price;
     
     if (!session()->get('add_order_items')){

          session()->put("add_order_items", [$data]);            
     }
     else{session()->push('add_order_items', $data);}

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
    

    return response()->json(['message'=>'Item Added to Cart', 'view'=>view('store.manage-order.items-view', compact('items', 'Service', 'form_id', 'price_data', 'coupon_discount'))->render(), 'items'=>$items], 200);
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
      'quantity'=>'bail|required|numeric|min:1|max:200']);

    $items = session('add_order_items');
    $index = $request->input('data-id')-1;
    
    $items[$index]['quantity'] =  $request->input('quantity');
    $items[$index]['estimated_price'] = $request->input('quantity')*($items[$index]['price']);
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
        'phone_number'=>['bail','required','numeric', 'unique:users,phone_number,'.$id, 'min:2', 'max:9999999999'],
        
        'address'=>'bail|nullable|string|min:2|max:50',
        'city'=>'bail|nullable|string|min:2|max:50',
        'state'=>'bail|nullable|string|min:2|max:50',
        'pin'=>'bail|nullable|numeric|min:2|max:999999',
        'latitude'=>'bail|nullable|numeric|min:-180|max:180',
        'longitude'=>'bail|nullable|numeric|min:-180|max:180',
        'landmark'=>'bail|nullable|string|min:2|max:200',
      ]);

      $user = User::create(['name'=>$request->input('name'), 
                      'email'=>$request->input('email'),
                      'phone_number'=>$request->input('phone_number'),  
                      'role'=> 4
                      ]);
      $address = Address::create(['address'=>$request->input('address'),
                        'pin'=>$request->input('pin'),
                        'city'=>$request->input('city'),
                        'state'=>$request->input('state'),
                        'user_id'=>$user->id,
                        'latitude'=>$request->input('latitude'),
                        'longitude'=>$request->input('longitude'),
                        'landmark'=>$request->input('landmark')
                      ]);
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
      $order = Order::create([ 'pickup_id'=>$id, 'customer_id'=>$customer_id, 
                               'address_id'=>$address_id,'runner_id'=>$assignedTo, 'store_id'=>$user->id,
                               'estimated_price'=>$prices['estimated_price'], 'cgst'=>$prices['cgst'],
                               'gst'=>$prices['gst'], 'total_price'=>round($prices['total_price'], 2),
                               'coupon_discount'=>$coupon_discount['discount'], 'coupon_id'=>$coupon_discount['coupon']
                            ]);
     
      foreach ($items as $item) {
          $item['order_id']=$order->id;
          $orderitem = OrderItems::create($item);            
          }
      DB::commit();
      return response()->json([ 'redirectTo'=>route('store.home'), 'message'=>'Order has been created Successfully'], 200); 
   } catch (Exception $e) {
      DB::rollback();
      return response()->json(['message'=>$e->getMessage()], 400);
   }
  }

  public function view(Request $request, $id){
    $order = Order::where('id', $id)->with('items')->first();
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
}
