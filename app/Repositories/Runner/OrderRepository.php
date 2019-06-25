<?php

namespace App\Repositories\Runner;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

use App\Model\{
	Service, Order,
	ServicePrice, Items
};
use App\User;
use App\Repositories\CommonRepository;
/**
 * Class OrderRepository.
 */
class OrderRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }

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

	    return ['price'=>$price->value, 'price_data'=>$price, 'service_data'=>$Service, 'item_data'=>$form_id,
                'code'=>1, 'msg'=> 'Success', 'details'=>
                            ['data'=>
                                    ['price'=>$price->value, 'price_data'=>$price, 'service_data'=>$Service, 'item_data'=>$form_id]
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
