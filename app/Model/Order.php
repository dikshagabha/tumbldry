<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['pickup_id', 'customer_id', 'address_id','runner_id', 'store_id', 'status',
 							'estimated_price', 'gst','cgst','total_price', 'coupon_id', 'coupon_discount', 'delivery_runner_id', 'date_of_arrival', 'discount', 'service_id', 'weight', 'delivery_mode','date_of_delivery'];
 	protected $dates = ['date_of_arrival', 'created_at', 'modified_at', 'date_of_delivery'];
 	public function items(){
 		return $this->hasMany('App\Model\OrderItems', 'order_id', 'id');
 	}

 	public function customer(){
 		return $this->hasOne('App\User', 'id', 'customer_id');
 	}

    public function store(){
        return $this->hasOne('App\User', 'id', 'store_id');
    }

 	public function address(){
 		return $this->hasOne('App\Model\Address', 'id', 'address_id');
 	}

 	public function service(){
 		return $this->hasOne('App\Model\Service', 'id', 'service_id');
 	}

    public function vendor(){
        return $this->hasMany('App\Model\VendorItem', 'order_id', 'id');
    }

    public function payment(){
        return $this->hasMany('App\Model\UserPayments', 'order_id', 'id');
    }

    public function delivery(){
        return $this->hasOne('App\User', 'id', 'delivery_runner_id');
    }


    public function getStatusNameAttribute(){
        if ($this->status==1) {
            return "Pending";
        }
        if ($this->status==6) {
            return "Delivered";
        }
        
        if (! $this->items()->where('status', '!=', 2)->count()) 
        {
            return "Processed";
        }
        if ($this->status==2) {
            return "Recieved";
        }

        if ($this->status==3) {
            return "Processing";
        }

        if ($this->status==4) {
            return "Processed";
        }        
        if ($this->status==5) {
            return "Out for Delivery";
        }
    }
 	public function getCustomerPhoneNumberAttribute(){
 		if ($this->customer()->count()) 
        {
            return $this->customer()->first()->phone_number;
        }
        return "--";
 	}

    public function getCustomerNameAttribute(){
        if ($this->customer()->count()) 
        {
            return $this->customer()->first()->name;
        }
        return "--";
    }
 	public function getRunnerNameAttribute(){
 		if ($this->delivery()->count()) 
        {
            return $this->delivery()->first()->name;
        }
        return "--";
 	}

 	public function getCustomerAddressAttribute(){
 		if ($this->address()->count()) 
        {
            return $this->address()->first()->address;
        }
        return "--";
 	}

 	public function getCustomerServiceAttribute(){
 		if ($this->service()->count()) 
        {
            return $this->service()->first()->name;
        }
        return "--";
 	}

    public function getServiceShortNameAttribute(){
        if ($this->service()->count()) 
        {
            if ($this->service()->first()->short_code != null) {
                return $this->service()->first()->short_code;
            }
            return $this->service()->first()->name;
        }
        return "--";
    }

 							
}
