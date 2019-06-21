<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Rules\{
    CheckName
};
class StorePickupRequest extends FormRequest
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
    public function rules(Request $request)
    {
      //if ($this->method()=="PUT") {
      //  $id = decrypt($this->route('manage_store'));
        if ($request->input('customer_id')) {
          return [
            'name' => ['bail', 'required', 'string', 'min:2', 'max:25', new CheckName],
            //'address_id'=>['bail','required', 'numeric'],
            //'email'=>['bail','required', 'email', 'min:2', 'max:100'],            
            'phone_number'=>['bail','required','numeric', 'min:2', 'max:9999999999'],            
            'customer_id'=>['bail','nullable', 'numeric'],
            'address_id'=>['bail','nullable', 'numeric'],           
            'address'=>'bail|required|string|min:2|max:50',
            'city'=>'bail|nullable|string|min:2|max:50',
            'state'=>'bail|nullable|string|min:2|max:50',
            'pin'=>'bail|required|numeric|min:2|max:999999',
            'latitude'=>'bail|nullable|numeric|min:-180|max:180',
            'longitude'=>'bail|nullable|numeric|min:-180|max:180',
            'landmark'=>'bail|nullable|string|min:2|max:200',
            'service'=>'bail|required|numeric',
            'request_time'=>'bail|required|string'
        ];
        }

        return [
          'name'=>['bail','required', 'string', 'min:2', 'max:100'],
          //'address_id'=>['bail','required', 'numeric'],
          'email'=>['bail','nullable', 'email', 'unique:users,email','min:2', 'max:100'],
          
          'phone_number'=>['bail','required','numeric', 'unique:users,phone_number', 'digits_between:8,15'],
          
          'user_id'=>['bail','nullable', 'numeric'],
          
          'address'=>'bail|required|string|min:2|max:50',
          
          'city'=>'bail|nullable|string|min:2|max:50',
          'state'=>'bail|nullable|string|min:2|max:50',
          
          'pin'=>'bail|required|numeric|min:2|max:999999',
          
          'latitude'=>'bail|nullable|numeric|min:-180|max:180',
          'longitude'=>'bail|nullable|numeric|min:-180|max:180',
          'landmark'=>'bail|nullable|string|min:2|max:200',
          'service'=>'bail|required|numeric',
          'request_time'=>'bail|required|string'

        ];
      
      
    }

    public function messages()
    {
      return [

        'address_id.required'=>"Please select an address.",
        
      ];
    }
}
