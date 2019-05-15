<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['pickup_id', 'customer_id', 'address_id','runner_id', 'store_id', 'status',
 							'estimated_price', 'gst','cgst','total_price', 'coupon_id', 'coupon_discount'];

 	public function items(){
 		return $this->hasMany('App\Model\OrderItems', 'order_id', 'id');
 	}
 							
}
