<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddPickupRequest extends FormRequest
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
      //if ($this->method()=="PUT") {
      //  $id = decrypt($this->route('manage_store'));
        return [
          'name'=>['bail','required', 'string', 'min:2', 'max:100'],
          //'address_id'=>['bail','required', 'numeric'],
          'email'=>['bail','required', 'email','unique:users,email,'.$id, 'min:2', 'max:100'],
          
          'phone_number'=>['bail','required','numeric', 'unique:users,phone_number,'.$id, 'min:2', 'max:9999999999'],
          
          'user_id'=>['bail','nullable', 'numeric'],
          
          'address'=>'bail|nullable|string|min:2|max:50',
          'city'=>'bail|nullable|string|min:2|max:50',
          'state'=>'bail|nullable|string|min:2|max:50',
          'pin'=>'bail|nullable|numeric|min:2|max:999999',
          'latitude'=>'bail|nullable|numeric|min:-180|max:180',
          'longitude'=>'bail|nullable|numeric|min:-180|max:180',
          'landmark'=>'bail|nullable|string|min:2|max:200',
          'service'=>'bail|required|numeric',
          'request_time'='bail|required|string'

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
