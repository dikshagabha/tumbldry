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
          'address_id'=>['bail','required', 'numeric'],
          'email'=>['bail','required', 'email','unique:users,email,'.$id, 'min:2', 'max:100'],
          'store_name'=>['bail','nullable','string', 'min:2', 'max:100'],
          'phone_number'=>['bail','numeric', 'unique:users,phone_number,'.$id, 'min:2', 'max:9999999999'],
        ];
      }else{
        return [
          'name'=>['bail','required', 'string', 'min:2', 'max:100'],
          'address_id'=>['bail','required', 'numeric'],
          'email'=>['bail','required', 'email','unique:users,email', 'min:2', 'max:100'],
          'store_name'=>['bail','nullable','string', 'min:2', 'max:100'],
          'phone_number'=>['bail','numeric', 'required',  'unique:users,phone_number','min:2', 'max:9999999999'],
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
