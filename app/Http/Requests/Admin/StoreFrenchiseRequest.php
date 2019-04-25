<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreFrenchiseRequest extends FormRequest
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
            $id = decrypt($this->route('manage_frenchise'));
            return [
              'store_name'=>['bail', 'required', 'string', 'min:2', 'max:100'],
              //'address_id'=>['bail','required', 'numeric'],
              'email'=>['bail','required', 'email','unique:users,email,'.$id, 'min:2', 'max:100'],
              'name'=>['bail', 'required', 'string', 'min:2', 'max:100'],
              'phone_number'=>['bail','numeric', 'unique:users,phone_number,'.$id, 'min:2', 'max:9999999999'],
            ];
        }
        return [
              'store_name'=>['bail', 'required', 'string', 'min:2', 'max:100'],
              //'address_id'=>['bail','required', 'numeric'],
              'email'=>['bail','required', 'email','unique:users,email', 'min:2', 'max:100'],
              'name'=>['bail','required', 'string', 'min:2', 'max:100'],
              'phone_number'=>['bail', 'required', 'numeric', 'unique:users,phone_number','min:2', 'max:9999999999'],
            ];

    }

    public function messages()
    {
      return [

        'address_id.required'=>"Please select an address.",
        'store_name.required'=>"Please enter a frenchise name.",
        'store_name.string'=>"Please enter a valid frenchise name.",
        'store_name.min'=>"Frenchise name must be between 2 to 100 characters.",
        'store_name.max'=>"Frenchise name must be between 2 to 100 characters.",
      ];
    }
}
