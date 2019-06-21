<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderItemImage extends Model
{
    protected $fillable = ['order_id', 'item_id', 'image', 'addon_id'];
	protected $dates = ['created_at', 'modified_at'];		
    public function addons(){
 		return $this->hasOne('App\Model\Service', 'id', 'addon_id');
 	}

 	public function getAddonNameAttribute(){
 		if ($this->addons()->count()) 
        {
            return $this->addons()->first()->name;
        }
        return "--";
 	}
}
