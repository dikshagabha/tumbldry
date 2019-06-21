<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VendorItem extends Model
{
    protected $fillable = ['vendor_id', 'status', 'item_id', 'service_id', 'order_id', 'address_id'];

    public function vendor(){
    	return $this->hasOne('App\User', 'id', 'vendor_id');
    }

     public function getVendorNameAttribute()
    {
        if ($this->vendor()->count()) 
        return $this->vendor()->first()->name; //some logic to return numbers

        return "--";
    }
}
