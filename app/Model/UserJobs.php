<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserJobs extends Model
{
    protected $fillable = ['order_id', 'user_id', 'type', 'status', 'start_time', 'end_time', 'rating', 'assigned_by'];
}
