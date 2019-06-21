<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserGst extends Model
{
    protected $fillable = ['user_id', 'cgst', 'gst', 'enabled'];
}
