<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LaundaryWeights extends Model
{
    protected $fillable = ['item_id', 'weight', 'weight_unit'];
}
