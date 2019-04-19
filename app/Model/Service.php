<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'description', 'status'];

    public function serviceprices(){
      return $this->hasMany('App\Model\ServicePrice');
    }
}
