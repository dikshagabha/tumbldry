<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PickupRequest extends Model
{
    protected $fillable = ['customer_id', 'store_id', 'address', 'request_mode', 'status', 'service'];

    public function customer()
    {
        return $this->hasOne('App\User', 'id', 'customer_id');
    }

    public function customer_address()
    {
        return $this->hasOne('App\Model\Address', 'id', 'address');
    }

    public function store()
    {
        return $this->hasOne('App\User', 'id', 'store_id');
    }

    public function getCustomerEmailAttribute()
    {
        return $this->customer()->first()->email; //some logic to return numbers
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
