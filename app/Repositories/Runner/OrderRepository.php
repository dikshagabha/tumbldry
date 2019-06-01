<?php

namespace App\Repositories\Runner;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

use App\Model\{
	Service,
	ServicePrice
};
use App\User;
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

    	return ['message'=>'Services found', 'data'=>$services, 'http_status'=>200];
    }

    public static function addons($request, $user, $form_type){

    	$services = Service::where('type', 2)->where('form_type', $form_type)->get();

    	return ['message'=>'Addons found', 'data'=>$services, 'http_status'=>200];

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

	    return ['price'=>$price->value, 'price_data'=>$price, 'service_data'=>$Service, 'item_data'=>$form_id];
    }

    public static function serviceItems($request, $user){
    	$type = Service::where('id', $request->input('service_id'))->select('form_type')->first();
	 	 
	 	$data = Items::where('type', $type->form_type)->get();
    	
    	return ['message'=>'Items found', 'data'=>$data, 'http_status'=>200];

    }
}