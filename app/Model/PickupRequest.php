<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PickupRequest extends Model
{
    protected $fillable = ['customer_id', 'store_id', 'address', 'request_mode', 'status', 'service', 'assigned_to', 'request_time'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at','request_time'];
    

    protected $appends = ['runner_name', 'customer_name','customer_email', 'service_name', 'customer_phone', 'customer_address_string'];

    public function customer()
    {
        return $this->hasOne('App\User', 'id', 'customer_id');
    }

    public function getStatusTextAttribute()
    {
        if ($this->status==1) {
            return "Pending";
        }

         if ($this->status==2) {
            return "Assigned";
        }

        if ($this->status==3) {
            return "Canceled";
        }
    }

    public function order()
    {
        return $this->belongsTo('App\Model\Order', 'id', 'pickup_id');
    }

    public function service()
    {
     	return $this->hasOne('App\Model\Service', 'id', 'service');
    }

    public function runner()
    {
        return $this->hasOne('App\User', 'id', 'assigned_to');
    }


    public function customer_address()
    {
        return $this->hasOne('App\Model\Address', 'id', 'address');
    }

    public function store()
    {
        return $this->hasOne('App\User', 'id', 'store_id');
    }

    public function getRunnerNameAttribute()
    {
        if ($this->runner()->count()) {
            return $this->runner()->first()->name;
        }
         return " -- ";//some logic to return numbers
    }

    public function getCustomerEmailAttribute()
    {
        return $this->customer()->first()->email; //some logic to return numbers
    }

    public function getServiceNameAttribute()
    {
     	return $this->service()->first()->name; //some logic to return numbers
    }


    public function getCustomerPhoneAttribute()
    {
        return $this->customer()->first()->phone_number; //some logic to return numbers
    }

    public function getCustomerAddressStringAttribute()
    {
        $data = $this->customer_address()->first();
        return $data->address; //some logic to return numbers
    }

    public function getCustomerNameAttribute()
    {
        return $this->customer()->first()->name; //some logic to return numbers
    }

    public function getStoreEmailAttribute()
    {
    	if ($this->store()->count()) {
    		return $this->store()->first()->email;
    	}
        return "N/A";
    }
}
