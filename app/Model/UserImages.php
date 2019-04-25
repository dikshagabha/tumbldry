<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class UserImages extends Model
{
    protected $fillable = ['user_id', 'address_proof', 'gst_certificate', 'bank_passbook', 'cheque', 'pan', 'id_proof',
                    'loi_copy', 'agreement_copy', 'rent_agreement', 'transaction_details'];
}
