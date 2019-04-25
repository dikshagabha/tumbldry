<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddStoreRequest extends FormRequest
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
      if ($this->method()=="PUT") {
        $id = decrypt($this->route('manage_store'));
        return [
          'name'=>['bail','required', 'string', 'min:2', 'max:100'],
          //'address_id'=>['bail','required', 'numeric'],
          'email'=>['bail','required', 'email','unique:users,email,'.$id, 'min:2', 'max:100'],
          'store_name'=>['bail','nullable','string', 'min:2', 'max:100'],
          'phone_number'=>['bail','numeric', 'unique:users,phone_number,'.$id, 'min:2', 'max:9999999999'],
          'user_id'=>['bail', 'numeric'],
          'address'=>'bail|required|string|min:2|max:50',
          'city'=>'bail|required|string|min:2|max:50',
          'state'=>'bail|required|string|min:2|max:50',
          'pin'=>'bail|required|numeric|min:2|max:999999',
          'latitude'=>'bail|required|numeric|min:-180|max:180',
          'longitude'=>'bail|required|numeric|min:-180|max:180',
          'landmark'=>'bail|required|string|min:2|max:200',

          'machine_count'=>'bail|required|numeric|min:1|max:9999',
          'boiler_count'=>'bail|required|numeric|min:1|max:9999',
          'machine_type'=>'bail|required|string|min:1|max:500',
          'boiler_type'=>'bail|required|string|min:1|max:500',
          'iron_count'=>'bail|required|numeric|min:1|max:9999',
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
      }else{
        return [
          'email' => 'bail|required|unique:users,email',
          'name' => 'bail|required|min:2|max:50|string',
          //'address_id'=>['bail','required', 'numeric'],
          'store_name' => 'bail|required|min:2|max:50|string',
          'phone_number' => 'bail|required|unique:users,phone_number|min:2|max:999999999',
          'machine_count'=>'bail|required|numeric|min:1|max:9999',
          'boiler_count'=>'bail|required|numeric|min:1|max:9999',
          'machine_type'=>'bail|required|string|min:1|max:500',
          'boiler_type'=>'bail|required|string|min:1|max:500',
          'iron_count'=>'bail|required|numeric|min:1|max:9999',
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
      }
    }

    public function messages()
    {
      return [

        'address_id.required'=>"Please select an address.",
        
      ];
    }
}
