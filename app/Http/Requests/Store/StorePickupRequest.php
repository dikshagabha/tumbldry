<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
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
          return [
            'name'=>['bail','required', 'string', 'min:2', 'max:100'],
            //'address_id'=>['bail','required', 'numeric'],
            'email'=>['bail','required', 'email', 'min:2', 'max:100'],
            
            'phone_number'=>['bail','required','numeric', 'min:2', 'max:9999999999'],
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