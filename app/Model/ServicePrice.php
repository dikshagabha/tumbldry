<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    protected $fillable = ['service_id', 'parameter', 'value', 'quantity', 'bsp', 'location', 'service_type', 'operator'];

    public function item_details(){
    	return $this->belongsTo('App\Model\Items', 'parameter', 'id');
    }

    public function addon_details(){
        return $this->belongsTo('App\Model\Service', 'parameter', 'id');
    }

    public function getItemNameAttribute()
    {
    	if ($this->item_details()->count()) {
    		return $this->item_details()->first()->name;
    	}

        return "N/A";
    }
}
