<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Appnings\Payment\Facades\Payment;

use App\Model\{
  Order,
  UserWallet,
  UserPayments,
  Location,
  UserPlan
};
use Auth;
use App\User;
use Carbon\Carbon;
use Mail;
use App\Repositories\CommonRepository;
class PaymentLinkController extends Controller
{
    
    public function pay(Request $request, $id, $type){
      if ($type==1) {
        $order = Order::where('id', $id)->first();
        $amount = $order->total_price;
        $name  = $order->customer->name;
        $add = $order->customer_address;
        $city = $order->address->city;
        $state=$order->address->state;
        $pin = $order->address->pin;
      }else
      {
        $order = UserPlan::where('id', $id)->with(['customer'=>function($q){
            $q->with('addresses');
        }])->first();
        $amount = $order->price;
        $name  = $order->customer->name;

        $add = $order->customer->address;
        $city = $order->customer->city;
        $state=$order->customer->state;
        $pin = $order->customer->pin;
      }
     //dd($order);
      $parameters = [
        'tid' => time().rand(111,999),
        'order_id' => $id,        
        'amount' => $amount,
        'billing_name'=>$name,
        'billing_address'=>$add,
        'billing_city'=>$city,
        'billing_state'=>$state,
        'billing_zip'=>$pin,
        'billing_country'=>"India",
        'billing_tel'=>$order->customer->phone_number,
        'billing_email'=>$order->customer->email,
        'merchant_param1'=>$type, 

        'delivery_name'=>$name,
        'delivery_address'=>$add,
        'delivery_city'=>$city,
        'delivery_state'=>$state,
        'delivery_zip'=>$pin,
        'delivery_country'=>"India",
        'delivery_tel'=>$order->customer->phone_number,
        'delivery_email'=>$order->customer->email,       
      ];
      $order = Payment::prepare($parameters);
      return Payment::process($order);
    }

    public function response(Request $request)
    {


        $response = Payment::response($request);
        //dd($response);
        if ($response['order_status'] != "Success") {
            return response()->json(['message'=>$response['failure_message']], 400);
        }
        
        if ($response['merchant_param1']==2) {
            $order = UserPlan::where('id', $response['order_id'])->first();
            $user = $order->user_id;
            $type = 15;

        }else{
            $order = Order::where('id', $response['order_id'])->first();
            $user = $order->customer_id;
            $type = 5;
        }
        UserPayments::insert( ['order_id'=>$response['order_id'], 'price'=>$response['amount'],
                                  'to_id'=>$order->store_id, 'type'=>$type, 'payment_mode'=>$response['payment_mode'],
                                  'transaction_id'=>$response['tracking_id'],
                                  'user_id'=>$user, 'created_at'=>Carbon::now(),
                                   'updated_at'=>Carbon::now()
                                ]);

        return view('success');
    
    }  

    public function success(Request $request)
    {
        // For default Gateway
        $response = Payment::response($request);
        
        
        dd($response);
    
    }  

    public function cancel(Request $request)
    {
        // For default Gateway
        $response = Payment::response($request);
        
        // For Otherthan Default Gateway
        $response = Payment::gateway('CCAvenue')->response($request);

        dd($response);
    
    }
}
  