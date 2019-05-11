<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $fillable = ['service_id', 'service_name', 'quantity', 'item', 'item_id'];
}
