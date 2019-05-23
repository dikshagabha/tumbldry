<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderItemImage extends Model
{
    protected $fillable = ['order_id', 'item_id', 'image', 'addon_id'];

    public function addons(){
 		return $this->hasOne('App\Model\Service', 'id', 'addon_id');
 	}
}
