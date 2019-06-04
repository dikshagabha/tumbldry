<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Appnings\Payment\Facades\Payment;

use App\Model\{
  Order,
  UserWallet,
  UserPayments,
  Location
};
use Auth;
use App\User;

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
    public function pay(Request $request){
    	
      $parameters = [
      
        'tid' => '1233221223322',
        
        'order_id' => '1232212',
        
        'amount' => '1200.00',
        
      ];
      
      $order = Payment::prepare($parameters);
      return Payment::process($order);
    }

    public function getPaymentMode(Request $request, $id){
     $activePage="order";
      $titlePage="Orders";
     $order = Order::where('id', $id)->first();
     $userwallet = UserWallet::where('user_id', $order->customer_id)->first();
     return view('store.payment.order.index', compact('activePage', 'titlePage', 'order', 'userwallet'));
     
    }

    public function payment(Request $request){
       $request->validate([
        'payment_mode'=>'bail|required|array',
        'order_id'=>'bail|required|numeric'
       ]);

      try{$order = Order::where('id', $request->input('order_id'))->first();
            $payment_modes = $request->input('payment_mode');
            $userwallet = UserWallet::where('user_id', $order->customer_id)->first();
      
            if (in_array(2, $request->input('payment_mode')) && $request->input('wallet_pay')>$userwallet->price) {
              return response()->json(["message"=>"User does not have enough money in wallet."], 400);
            }
      
            if (in_array(2, $request->input('payment_mode')) && in_array(1, $request->input('payment_mode'))
                && in_array(3, $request->input('payment_mode')) ) {
              
              if ($request->input('cash_pay')+$request->input('wallet_pay')+$request->input('loyality_points') 
                != $order->total_price) {
                return response()->json(["message"=>"Please enter valid price."], 400);
              }
            }
            $cash_pay = $wallet_pay = $loyality_pay=0;
            if (in_array(1, $request->input('payment_mode'))) {
              $cash_pay = $request->input('cash_pay');
            }

            if (in_array(2, $request->input('payment_mode'))) {
              $wallet_pay = $request->input('wallet_pay');
            }

            if (in_array(3, $request->input('payment_mode'))) {
              $loyality_pay = $request->input('loyality_points');
            }

            if ($cash_pay+$loyality_pay+$wallet_pay != $order->total_price) {
              return response()->json(["message"=>"Please enter valid price."], 400);
            }

          
      
            $paymentData = [];
            
            if (in_array(1, $request->input('payment_mode'))) {
              array_push($paymentData , [
                                    'order_id'=>$order->id, 'price'=>$request->input('cash_pay'),
                                    'to_id'=>$this->user->id, 'type'=>1,
                                     'user_id'=>$order->customer_id
                                  ]);
            }
      
            if (in_array(2, $request->input('payment_mode'))) {
              array_push($paymentData , [
                                    'order_id'=>$order->id, 'price'=>$request->input('wallet_pay'),
                                    'to_id'=>$this->user->id, 'type'=>2,
                                    'user_id'=>$order->customer_id
                                  ]);
            }
            $points = $order->total_price*40/100;
            $insert = $points;
            $userwallet->loyality_points =  $userwallet->loyality_points+$points;
            if (in_array(3, $request->input('payment_mode'))) {
              array_push($paymentData , [
                                    'order_id'=>$order->id, 'price'=>$request->input('loyality_points'),
                                    'to_id'=>$this->user->id, 'type'=>3,
                                    'user_id'=>$order->customer_id
                                  ]);
              //$userwallet->loyality_points =  $userwallet->loyality_points-$request->input('loyality_points');
              $userwallet->loyality_points = $points;
            }
            array_push($paymentData , [
                                     'order_id'=>$order->id, 'price'=>$points,
                                     'to_id'=>$order->customer_id, 'type'=>0,
                                     'user_id'=>0
                                  ]);
      
            $payment= UserPayments::insert($paymentData);
            $userwallet->save();
            return response()->json(["message"=>"Payment Success", 'redirectTo'=>route('store.create-order.index')], 200);
          }catch(Exception $e){
            return response()->json(["message"=>"Something went wrong"], 400);
          }
    }
}
  