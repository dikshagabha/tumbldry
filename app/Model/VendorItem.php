<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VendorItem extends Model
{
    protected $fillable = ['vendor_id', 'status', 'item_id', 'service_id', 'order_id', 'address_id'];
}
