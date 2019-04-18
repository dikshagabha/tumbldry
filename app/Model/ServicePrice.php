<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    protected $fillable = ['service_id', 'parameter', 'value'];
}
