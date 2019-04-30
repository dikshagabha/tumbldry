<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    protected $fillable = ['service_id', 'parameter', 'value', 'quantity', 'bsp', 'location', 'service_type', 'operator'];

    public function item_details(){
    	return $this->belongsTo('App\Model\Items', 'parameter', 'id');
    }

    public function getItemNameAttribute()
    {
        return $this->item_details()->first()->name; //some logic to return numbers
    }
}
