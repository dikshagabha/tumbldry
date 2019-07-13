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
        return [
            'name'=>['bail','required', 'string', 'min:2', 'max:100',  new CheckName],
            'phone_number'=>['bail','required','numeric', 'min:2', 'digits_between:8,15'],
            'service'=>'bail|required|numeric',
            'request_time'=>'bail|required|string',
            'end'=>'bail|required|string',
            'start'=>'bail|required|string',
        ];
        
      
    }

    public function messages()
    {
      return [

        'address_id.required'=>"Please select an address.",
        
      ];
    }
}
