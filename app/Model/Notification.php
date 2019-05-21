<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
      protected $table="notifications";

    protected $fillable = ['message', 'data', 'from_id', 'to_id', 'type', 'notifiable_type', 'notifiable_id'];

}
