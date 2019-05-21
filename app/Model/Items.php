<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
   protected $fillable = ['name', 'type', 'status'];
}
