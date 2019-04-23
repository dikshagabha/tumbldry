<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddAddressRequest extends FormRequest
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
        return [
          'address'=>['required', 'string', 'min:2', 'max:100'],
          'state'=>['required', 'string', 'min:2', 'max:50'],
          'city'=>['required', 'string', 'min:2', 'max:50'],
          'pin'=>['required', 'numeric'],
          'location_id'=>['required', 'numeric']
        ];
      }

        public function messages()
        {
          return [
            'pin.required'=>"Please enter a pin.",
          ];
        }
    
}
