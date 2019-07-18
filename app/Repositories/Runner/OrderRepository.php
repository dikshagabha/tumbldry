<?php

namespace App\Repositories\Runner;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

use App\Model\{
	Service, Order,
	ServicePrice, Items, Location, OrderItems, OrderItemImage,
    SMSTemplate
};
use App\User;
use App\Repositories\CommonRepository;
use App\Rules\{
    CheckName
};
use DB;
/** * Class OrderRepository. */ class OrderRepository extends BaseRepository {
/** * @return string *  Return the model */ public function model() { //return
YourModel::class; }

    public static function services($request, $user){
    	$services = Service::where('type', 1)->get();

    	return ['message'=>'Success', 'data'=>$services, 'http_status'=>200, 
                    'code'=>1, 'msg'=> 'Success', 'details'=>['data'=>$services]
                ];
    }

    public static function addons($request, $user, $form_type){

    	$services = Service::where('type', 2)->where('form_type', $form_type)->get();

    	return ['message'=>'Success', 'data'=>$services, 'http_status'=>200,
                            'code'=>1, 'msg'=> 'Success', 'details'=>['data'=>$services]
                ];

    }

    public static function servicePrice($request, $user){

    	$store = User::where("id",  $user->user_id)->first();

    	$location = Location::where('pincode', $store->pin)->first();

    	$Service = Service::where("id", $request->input('service_id'))->first();

	    if ($Service->form_type !=2) {
	     	$form_id = Items::where("name", 'LIKE','%'.$request->input('item').'%' )->where('type', $Service->form_type)->first();
	    }else{
	    	$form_id = Items::where('status', 1)->where('type', $Service->form_type)->first();
	    }
	    if (!$form_id) {
	       	return ['message'=>'We donot have details for this item.', 'http_status'=>400];
	    }

	    if ($Service->form_type ==2 ) {
	      $form_id = Items::where('type', 2)->first();
	    }
	    $price = ServicePrice::where(['service_id'=>$Service->id])->where('parameter', $form_id->id)
	            ->where('location', 'LIKE', '%'.$location->city_name.'%')->first();
    
	    if (!$price) {
	     $price = ServicePrice::where(['service_id'=>$Service->id])->where('parameter', $form_id->id)
	              ->where('location', 'global')->first();
	    }

        $addons_input = $request->input['selected_addons'];
        $addons_prices = null;
        if ($addons_input) {
          // Price of addons
          $addons_prices = ServicePrice::where('service_id', $request->input('service'))->whereIn('parameter', 
                      $addons_input)->where('service_type', 0)
                      ->where('location','like' ,'%'.$this->location->city_name.'%')->sum('value');
          
          if(!$addons_prices){
            $addons_prices = ServicePrice::where('service_id', $request->input('service'))
                      ->whereIn('parameter', $addons_input)->where('location','like' , 'global')->where('service_type', 0)->sum('value');
          }
        }

	    return ['price'=>$price->value, 'price_data'=>$price, 'service_data'=>$Service, 'item_data'=>$form_id, 
                'addons_data'=>$addons_prices,
                'code'=>1, 'msg'=> 'Success', 'details'=>
                            ['data'=>
                                    ['price'=>$price->value, 'price_data'=>$price, 'service_data'=>$Service, 'item_data'=>$form_id],
                                    'addons_data'=>$addons_prices
                            ]
                ];
    }

    public static function serviceItems($request, $user){

    	$type = Service::where('id', $request->input('service_id'))->select('form_type')->first();
	 	 
	 	$data = Items::where('type', $type->form_type)->get();

        return ['message'=>'Items found', 'data'=>$data, 'http_status'=>200,
                'code'=>1, 'msg'=> 'Success', 'details'=>
                            [
                                'data'=>$data
                            ] 
                ];

    }

    public static function createOrder($request, $user){
        $validatedData = $request->validate(['delivery_mode'=>'bail|required|integer',
                                            'service_id'=>'bail|required|integer']);
        try{
        if ($request->input('pickup_id')) {
         $id = $request->input('pickup_id');     
         $pickup = PickupRequest::where("id", $id)->first();
         $customer_id=$pickup->customer_id;
         $address_id = $pickup->address_id;
         $assignedTo = $pickup->assignedTo;

         if (!$pickup) {
               return response()->json(['message'=>'PickupRequest not found'], 400);
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
                    'name'=>['bail','required', 'string', 'min:2', 'max:25', new CheckName],
                    'phone_number'=>['bail','required','numeric', 'unique:users,phone_number', 'min:2', 'digits_between:8,15'],
                    'address' => 'bail|required|string|max:500',
                    'city' => 'bail|required|max:255',
                    'state' => 'bail|required|max:255',
                    'pin' => 'bail|required|min:1|max:15',
                    'landmark' => 'bail|nullable|string|max:500',
                    'latitude' => 'bail|nullable|numeric|min:-90|max:90',
                    'longitude' => 'bail|nullable|numeric|min:-180|max:180',
                  ]);
                $customer = User::create(['name'=>$request->input('name'), 
                                  'email'=>$request->input('email'),
                                  'phone_number'=>$request->input('phone_number'),  
                                  'role'=> 4, 'user_id'=>$this->user->id
                                  ]);
                $customer_id = $customer->id;
                $wallet  = UserWallet::create(['user_id'=>$user->id, 'price'=>0]);
                $address = Address::create($request->only('address', 'latitude', 'longitude', 'city', 'state', 'pin'));
                $address_id = $address->id;
            }
        }

        if (!$address_id) {
            return response()->json(['message'=>'Please enter an address'], 400);
        }
        $items = $request->input('items');
        $total = 0;
        $items_data = [];
        foreach ($items as $key => $value) {
            $item_price = self::servicePrice($request, $user);
            $data['item']=$item_price['item_data']->name;
            if (isset($value['quantity'])) {
                $data['quantity'] = $value['quantity'];
            }

            $data['price']=$item_price['price'];
            $data['price_data']=$item_price['price_data'];
            $data['item_data']=$item_price['item_data'];
            $data['item_id'] = $item_price['item_data']->id;
            $data['addons_data']=$item_price['addons_data'];

            $form_type = Service::where('id', $request->input('service_id'))->first();  
            $data['service_name'] = $form_type->name;
            if ($form_type->form_type!=2) {
              $data['price'] = ($quantity*($data['price']));
            }
            
            array_push($items_data, $data);
        }

        $total = 0;

        foreach ($items_data as $key => $value) {
           $total += $value['price'];
           if ($value['addons_data']) {
               $total+=$value['addons_data']->value;
           }
        }

        $gst = 9;
        $cgst = 9;
        $store = User::where('id', $user->user_id)->with('gst')->first();
        if ($store->gst) {
          $gst = 0;
          $cgst = 0;
          if ($store->gst->enabled) {
            $gst = $store->gst->gst;
            $cgst = $store->gst->cgst;
          }
        }

        $gst_price = $total*($gst/100);
        $cgst_price = $total*($cgst/100);

        $price_data = ['total'=>$total, 'gst'=>round($gst_price, 2), 'cgst'=>round($cgst_price, 2), 'total_price'=>$total+$gst_price+$cgst_price];

        $order = Order::create([ 'pickup_id'=>$request->input('pickup_id'), 'customer_id'=>$customer_id, 
                               'address_id'=>$address_id, 'runner_id'=>$user->id, 'store_id'=>$user->user_id,
                               'estimated_price'=>$price_data['total'], 'cgst'=>$price_data['cgst'],
                               'gst'=>$price_data['gst'], 'total_price'=>round($price_data['total_price'], 2),
                               'coupon_discount'=>'', 'coupon_id'=>'', 'discount'=>'', 'service_id'=>$request->input('service_id'),
                               'delivery_mode'=>$request->input('delivery_mode'), 'status'=>1]);

        $item_val = 1;
        foreach ($items_data as $item) {
           // print_r($item['quantity']);
            $quantity = 1;
            if (isset($item['quantity'])) {
                $quantity = $item['quantity'];
            }

              for ($i=1; $i <= $quantity; $i++) { 
                $item['quantity']=1;
                $item['order_id']=$order->id;
                $item['status'] = 1;
                $item['item_value']=$item_val;
                $item['service_id']=$request->input('service_id');
                
                $item_val++;
                ///print_r($item);die;

                
                $orderitem = OrderItems::create($item);
                $itemData = [];
                if (isset($item['selected_addons'])) {
                foreach ($item['selected_addons'] as $key => $value) 
                    {
                     
                      array_push($itemData, ['order_id'=>$order->id, 'item_id'=>$orderitem->id, 'addon_id'=>$value, 'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now(), 'image'=>null]);
                    }
                }

                if (isset($item['images'])) {
                 foreach ($item['images'] as $key => $value) 
                {
                   //print_r($value);
                  array_push($itemData, ['order_id'=>$order->id, 'item_id'=>$orderitem->id, 'image'=>$value, 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now(), 'addon_id'=>null]);
                }
                }
                $order_items = OrderItemImage::insert($itemData);
              } 
          }

          $message = SMSTemplate::where('title', 'like','%Order Created%')->select('description')->first();
          //dd($message);
          $message = $message->description;



          $mes = str_replace('@customer_name@', $request->input('name'), $message);

          $mes = str_replace('@order_id@', $order->id, $mes);
          $mes = str_replace('@total_clothes@', $order->items->sum('quantity'), $mes);
          $weight = '';
          if ($order->items->first()->weight) {
            $weight = $order->items->first()->weight;
          }
          $mes = str_replace('@weight@', $order->items->first()->weight, $mes);
          $mes = str_replace('@service@', $order->service->name, $mes);

          $res = CommonRepository::sendmessage($request->input('phone_number'), $mes);

          DB::commit();
          return ['message'=>'Success', 'http_status'=>200,
                        'code'=>1, 'details'=>['response_data'=>['price_data'=>$price_data, 'items_data'=>$items_data, 'order_data'=>$order] ]];
        }catch (Exception $e) {
          DB::rollback();
          return response()->json(['message'=>$e->getMessage()], 400);
        }
        
    }


    public static function sendLink($request, $id){
        $order = Order::where('id', $id)->first();

        $phone = $order->customer_phone_number;
        if ($request->input('phone_number')) {
            $phone = $request->input('phone_number');
        }
        
        $response = CommonRepository::sendmessage($phone, route('order.pay', $id));
        if ($response) {
            return ['message'=>'Message Sent', 'http_status'=>200,
                        'code'=>1, 'details'=>['response_data'=>$response]];
        }

        return ['message'=>'Message not Sent', 'http_status'=>400,
                        'code'=>2, 'details'=>['response_data'=>$response]];
        
    }
}
