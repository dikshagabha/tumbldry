<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

use Auth;

class editProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      $id = Auth::user()->id;

      
      $data =  [
          'name'=>['bail','required', 'string', 'min:2', 'max:100'],
          'email'=>['bail','required', 'email','unique:users,email,'.$id, 'min:2', 'max:100'],
          'store_name'=>['bail','nullable','string', 'min:2', 'max:100'],
          'phone_number'=>['bail','required','numeric', 'unique:users,phone_number,'.$id, 'min:2', 'max:9999999999'],          
          'address'=>'bail|nullable|string|min:2|max:50',
          'city'=>'bail|nullable|string|min:2|max:50',
          'state'=>'bail|nullable|string|min:2|max:50',
          'pin'=>'bail|nullable|numeric|min:2|max:999999',
          'latitude'=>'bail|nullable|numeric|min:-180|max:180',
          'longitude'=>'bail|nullable|numeric|min:-180|max:180',
          'landmark'=>'bail|nullable|string|min:2|max:200',

          'machine_count'=>'bail|nullable|numeric|min:1|max:9999',
          'boiler_count'=>'bail|nullable|numeric|min:1|max:9999',
          'machine_type'=>'bail|nullable|string|min:1|max:500',
          'boiler_type'=>'bail|nullable|string|min:1|max:500',
          'iron_count'=>'bail|nullable|numeric|min:1|max:9999',
          
          'property_type'=>'bail|required|numeric|min:1|max:2',
          'store_size'=>'bail|required_if:property_type,1|nullable|numeric|min:1|max:9999',
          'store_rent'=>'bail|required_if:property_type,1|nullable|numeric|min:1|max:9999',
          'rent_enhacement'=>'bail|required_if:property_type,1|nullable|numeric|min:1|max:9999',
          'rent_enhacement_percent'=>'bail|required_if:property_type,1|nullable|numeric|min:1|max:99',
          'landlord_name' => 'bail|required_if:property_type,1|nullable|min:2|max:50|string',
          'landlord_number' => 'bail|required_if:property_type,1|nullable|min:2|max:999999999|numeric',

          'address_proof' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'gst_certificate' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'bank_passbook' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'cheque' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'pan' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'id_proof' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'loi_copy' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'transaction_details' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'agreement_copy' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',
          'rent_agreement' => 'bail|nullable|file|mimes:pdf,png,jpg,jpeg|max:10000',

          'account_number'=>'bail|nullable|string|min:1|max:50',
          'bank_name'=>'bail|nullable|string|min:1|max:50',
          'branch_name'=>'bail|nullable|string|min:1|max:50',
          'ifsc_code'=>'bail|nullable|string|min:1|max:50',
          'gst_number'=>'bail|nullable|string|min:1|max:50',
          'pan_number'=>'bail|nullable|string|min:1|max:50',
          'id_proof_number'=>'bail|nullable|string|min:1|max:50',
        ];

        return $data;
    }
}
