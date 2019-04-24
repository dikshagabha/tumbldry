<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $fillable=['account_number', 'bank_name', 'user_id', 'branch_code','ifsc_code',
							'gst_number','id_proof_number', 'pan_card_number'];
}
