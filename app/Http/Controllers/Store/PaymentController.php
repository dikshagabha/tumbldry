<?php

namespace App\Http\Controllers\Store;

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
class PaymentController extends Controller
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
          return $next($request);
      });
    }
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

    public function getPaymentMode(Request $request, $id){
     $activePage="order";
      $titlePage="Orders";
     $order = Order::where('id', $id)->first();
     $userwallet = UserWallet::where('user_id', $order->customer_id)->first();
     return view('store.payment.order.index', compact('activePage', 'titlePage', 'order', 'userwallet'));
     
    }

    public function payment(Request $request){
       $order_id =  $request->input('order_id');
       //dd($request->input('payment_mode'));
       if ($request->input('send_link')) {
         $validate=$request->validate([
          'phone_number'=>'bail|required|numeric|digits_between:8,15']);
         $response =  CommonRepository::sendmessage($request->input('phone_number'), "Hello, \n Please use link for payment ".route('order.pay', $order_id));
         return response()->json(["message"=>"Payment Success", 'redirectTo'=>route('store.create-order.index')], 200);
       }
       $request->validate([
        'payment_mode'=>'bail|required|array',
        'order_id'=>'bail|required|numeric'
       ]);
      try{$order = Order::where('id', $request->input('order_id'))->first();
            $payment_modes = $request->input('payment_mode');
            $userwallet = UserWallet::where('user_id', $order->customer_id)->first();

            if (!$userwallet) 
            {
              $userwallet = UserWallet::create(['user_id'=>$order->customer_id, 'price'=>0]);
            }
      
            if ( $userwallet && in_array(2, $request->input('payment_mode')) && $request->input('wallet_pay')>$userwallet->price) {
              return response()->json(["message"=>"User does not have enough money in wallet."], 400);
            }
      
            if (in_array(2, $request->input('payment_mode')) && in_array(1, $request->input('payment_mode'))
                && in_array(3, $request->input('payment_mode')) ) {
              
              if ($request->input('cash_pay')+$request->input('wallet_pay')+$request->input('loyality_points') 
                != $order->total_price) {
                return response()->json(["message"=>"Please enter valid price."], 400);
              }
            }
            $cash_pay = $wallet_pay = $loyality_pay=$card_pay=0;
            if (in_array(1, $request->input('payment_mode'))) {
              $cash_pay = $request->input('cash_pay');
            }

            if (in_array(2, $request->input('payment_mode'))) {
              $wallet_pay = $request->input('wallet_pay');
            }

            if (in_array(3, $request->input('payment_mode'))) {
              $loyality_pay = $request->input('loyality_points');
            }
            if (in_array(4, $request->input('payment_mode'))) {
              $request->validate([
                'transaction_id'=>'bail|required|string|min:1|max:50',
                'card_price'=>'bail|required|numeric|min:1|max:20000000'
               ]);
              $card_pay = $request->input('card_price');
            }
            if ($cash_pay+$loyality_pay+$wallet_pay+$card_pay != $order->total_price) {
              return response()->json(["message"=>"Please enter valid price."], 400);
            }

          
      
            $paymentData = [];
            
            if (in_array(1, $request->input('payment_mode'))) {
              array_push($paymentData , [
                                    'order_id'=>$order->id, 'price'=>$request->input('cash_pay'),
                                    'to_id'=>$order->store_id, 'type'=>1,'transaction_id'=>null,
                                     'user_id'=>$order->customer_id, 'created_at'=>Carbon::now(),
                                     'updated_at'=>Carbon::now()
                                  ]);
            }
      
            if (in_array(2, $request->input('payment_mode'))) {
              array_push($paymentData , [
                                    'order_id'=>$order->id, 'price'=>$request->input('wallet_pay'),
                                    'to_id'=>$order->store_id, 'type'=>2,'transaction_id'=>null,
                                    'user_id'=>$order->customer_id, 'created_at'=>Carbon::now(),
                                     'updated_at'=>Carbon::now()
                                  ]);

              $userwallet->price = $userwallet->price - $request->input('wallet_pay');
            }

            if (in_array(4, $request->input('payment_mode'))) {
              array_push($paymentData , [
                                    'order_id'=>$order->id, 'price'=>$request->input('card_price'),
                                    'to_id'=>$order->store_id, 'type'=>4, 
                                    'transaction_id'=>$request->input('transaction_id'),
                                    'user_id'=>$order->customer_id, 'created_at'=>Carbon::now(),
                                     'updated_at'=>Carbon::now()
                                  ]);

              $userwallet->price = $userwallet->price - $request->input('wallet_pay');
            }
            $points = $order->total_price*40/100;
            $insert = $points;
            $userwallet->loyality_points =  $userwallet->loyality_points+$points;
            if(in_array(3, $request->input('payment_mode'))){
              array_push($paymentData , [
                                    'order_id'=>$order->id, 'price'=>$request->input('loyality_points'),
                                    'to_id'=>$order->store_id, 'type'=>3,'transaction_id'=>null,
                                    'user_id'=>$order->customer_id, 'created_at'=>Carbon::now(),
                                     'updated_at'=>Carbon::now()
                                  ]);
              $userwallet->loyality_points = $points;
            }
            array_push($paymentData , [
                                     'order_id'=>$order->id, 'price'=>$points,
                                     'to_id'=>$order->customer_id, 'type'=>0,'transaction_id'=>null,
                                     'user_id'=>0, 'created_at'=>Carbon::now(),
                                     'updated_at'=>Carbon::now()
                                  ]);
      
            $payment= UserPayments::insert($paymentData);
            $userwallet->save();
            return response()->json(["message"=>"Payment Success", 'redirectTo'=>route('store.create-order.index')], 200);
          }catch(Exception $e){
            return response()->json(["message"=>"Something went wrong"], 400);
          }
    }

    public function getPlansPayment(Request $request, $id){

     $activePage="plans";
     $titlePage="Plans";
     $order = UserPlan::where('id', $id)->first();
     //$userwallet = UserWallet::where('user_id', $order->customer_id)->first();
     return view('store.payment.plans.index', compact('activePage', 'titlePage', 'order', 'userwallet'));
     
    }


    public function plansPayment(Request $request){
       $request->validate([
        'payment_mode'=>'bail|required|array',
        'order_id'=>'bail|required|numeric'
       ]);

      try{
            $plan = UserPlan::where('id', $request->input('order_id'))->first();
            //dd($plan->customer_id);
            $payment_modes = $request->input('payment_mode');
            
            $wallet = UserWallet::where('user_id', $plan->user_id)->first();
            if (!$wallet) {
              $wallet = UserWallet::create(['user_id'=>$plan->user_id, 'price'=>0]);
            }
            $wallet->price= $wallet->price+$plan->price;      
            $paymentData = [];
            
            if (in_array(1, $request->input('payment_mode'))) {
              array_push($paymentData , [
                                    'order_id'=>$plan->id, 'price'=>$request->input('cash_pay'),
                                    'to_id'=>Auth::user()->id, 'type'=>11,
                                     'user_id'=>$plan->user_id,'created_at'=>Carbon::now(),
                                     'updated_at'=>Carbon::now()
                                  ]);
            }
      
           
      
            $payment= UserPayments::insert($paymentData);
            $wallet->save();
            return response()->json(["message"=>"Payment Success", 'redirectTo'=>route('manage-plans.index')], 200);
          }catch(Exception $e){
            return response()->json(["message"=>"Something went wrong"], 400);
          }
    }
}
  