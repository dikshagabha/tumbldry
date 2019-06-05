<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

use App\Model\Token;
use App\User;
use App\Model\Address;
use App\Model\Order;
use App\Model\Coupon;
use App\Model\Service;
use Carbon\Carbon;
/**
 * Class CommonRepository.
 */
class CommonRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }

    public static function random_str($length=8, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
	    $pieces = [];
	    $max = mb_strlen($keyspace, '8bit') - 1;
	    for ($i = 0; $i < $length; ++$i) {
	        $pieces []= $keyspace[random_int(0, $max)];
	    }
	    return implode('', $pieces);
	}

    public static function getManageToken($token, $user_id): Token
    {
        return $token_get = Token::updateOrCreate(['user_id' => $user_id], ['token' => $token]);
    }

    public static function sendmessage($user, $message)
    {
        $url = 'http://push.sanketik.net//api/push?accesskey=jzzUlHL4NqhWs6VHzmUkGkYTaQKD7T&to='.$user.'&text='.$message.'&from=TBLDRY';

         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_POST, 0);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

         $response = curl_exec ($ch);
         $err = curl_error($ch);  //if you need
         curl_close ($ch);
         
         //dd($response);

         if ($response) {
            $response = json_decode($response);
            $array = get_object_vars($response);
         }
         return $response;
    }

    public static function search_vendor($address, $service){
        $pin = Address::where('id', $address)->first();
        $pin = $pin->pin;
        //dd($pin);
        $users = User::where('role', 6)->where('service_id', $service)->where('status', 1)
                 ->whereHas('addresses', function($q) use($pin){
                    $q->where('pin', $pin);
                })
                ->with('addresses')->get();
        //dd($users);
        return $users;
    }

    public static function get_valid_coupon($customer_phone, $service_id, $current_order_details){
        $customer = User::where('phone_number', $customer_phone)->first();

        $last_order = null;
        if ($customer) {
           $last_order = Order::where('customer_id', $customer->id)->get();
        }
        //dd(!$last_order);
        //Discount on first Order        
        if (!$last_order || !$last_order->count()) {
            $price = Coupon::where('coupon', '=', 'First Order')->first();

            return ['type'=>2, 'value'=>$price->coupon_price, 'name'=>'First Order'];
        }

        //x% off on service 1 when using service 2
        $service_details = Coupon::where('coupon','=','Service Discount')->get();
        //dd($service_details);
        $service_details = $service_details->whereIn('parameter', $last_order->pluck('service_id')->unique());
        $service_details = ($service_details->where('value', $service_id))->first();
        
        if ($service_details && $service_details->count()){
            return ['type'=>2, 'value'=>$service_details->coupon_price, 'name'=>'Service Discount'];
        }
       // dd("kasld");
        $ser = Service::where('id', $service_id)->first();

        if ($ser->form_type==1) {
          $service_details = Coupon::where('coupon', '=' ,'Laundary Discount')->get();
          $service_details = $service_details->whereIn('parameter','>=', $last_order->where('service_id', $service_id)->first()->items->sum('quantity'));
          //$service_details = ($service_details->where('value', $current_order_details['weight']));  
          if ($service_details->count()){
                return ['type'=>3, 'value'=>$service_details->coupon_price];
          }  
        }

        $coupon = Coupon::where('coupon', '=','WeekDay Discount')->get();

        $coupon=$coupon->where('parameter', Carbon::now()->dayOfWeek)->first();
        
        //dd(Carbon::now()->dayOfWeek);

        if ($coupon && $coupon->count()){
            return ['type'=>2, 'value'=>$coupon->coupon_price, 'name'=>'WeekDay Discount'];
        }  


    }   

}
