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
    // protected $user;
    // protected $useraddress;
    // protected $location;
    // protected $gst;
    // protected $cgst;

    // public function __construct(){
    //   $this->middleware(function($request, $next) {
    //       $this->user = Auth::user()->load('addresses', 'gst');
    //       $this->useraddress = $this->user->addresses->first();
    //       $this->location = Location::where('pincode', $this->useraddress->pin)->first();
    //       $this->gst = 9;
    //       $this->cgst = 9;
          
    //       if ($this->user->gst) {
    //         $this->gst = 0;
    //         $this->cgst = 0;
    //         if ($this->user->gst->enabled) {
    //           $this->gst = $user->gst->gst;
    //           $this->cgst = $user->gst->cgst;
    //         }
    //       }
    //       return $next($request);
    //   });
    // }
    public function pay(Request $request, $id){
      $order = Order::where('id', $id)->first();
      $parameters = [
        'tid' => time().rand(111,999),
        'order_id' => $id,        
        'amount' => $order->total_price,
        'billing_name'=>$order->customer->name,
        'billing_address'=>$order->customer_address,
        'billing_city'=>$order->address->city,
        'billing_state'=>$order->address->state,
        'billing_zip'=>$order->address->pin,
        'billing_country'=>"India",
        'billing_tel'=>$order->customer->phone_number,
        'billing_email'=>$order->customer->email,

        'delivery_name'=>$order->customer->name,
        'delivery_address'=>$order->customer_address,
        'delivery_city'=>$order->address->city,
        'delivery_state'=>$order->address->state,
        'delivery_zip'=>$order->address->pin,
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

        $order = Order::where('id', $response['order_id'])->first();
        
        UserPayments::insert( ['order_id'=>$response['order_id'], 'price'=>$response['amount'],
                              'to_id'=>$order->store_id, 'type'=>5, 'payment_mode'=>$response['payment_mode'],
                              'transaction_id'=>$response['tracking_id'],
                              'user_id'=>$order->customer_id, 'created_at'=>Carbon::now(),
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
  