<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $fillable = ['service_id', 'service_name', 'quantity', 'item', 'item_id', 'order_id'];

    public function service(){
 		return $this->hasOne('App\Model\Service', 'id', 'service_id');
 	}

 	public function getServiceNameAttribute(){
 		if ($this->service()->count()) 
        {
            return $this->service()->first()->name;
        }
        return "--";
 	}

}
