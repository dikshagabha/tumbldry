<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $fillable = ['service_id', 'service_name', 'quantity', 'item', 'item_id', 'order_id'];

    public function service(){
 		return $this->hasOne('App\Model\Service', 'id', 'service_id');
 	}

 	public function order(){
 		return $this->hasOne('App\Model\Order', 'id', 'order_id');
 	}

 	public function item(){
 		return $this->hasOne('App\Model\Item', 'id', 'item_id');
 	}

 	public function itemimage(){
 		return $this->hasMany('App\Model\OrderItemImage', 'item_id', 'id');
 	}

 	public function getServiceNameAttribute(){
 		if ($this->service()->count()) 
        {
            return $this->service()->first()->name;
        }
        return "--";
 	}

 	public function getItmeNameAttribute(){
 		if ($this->item()->count()) 
        {
            return $this->item()->first()->name;
        }
        return "--";
 	}

}
