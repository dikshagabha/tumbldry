<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
          'name'=>['bail', 'required', 'string', 'min:2', 'max:100'],
          'description'=>['bail', 'nullable','string', 'min:2', 'max:200'],
          'type'=>['bail', 'required','numeric', 'min:0', 'max:2'],
          'parameter'=>['bail', 'required', 'array', 'min:1'],
          'parameter.*'=>['bail', 'required', 'string', 'min:1', 'max:50'],
          'price'=>['bail', 'required', 'array', 'min:1'],
          'price.*'=>['bail', 'required', 'numeric', 'min:1', 'max:999999'],
        ];
    }

    public function messages()
    {
      return [

        'parameter.*.required'=>"Please enter a parameter.",
        'parameter.*.string'=>"Please enter a valid parameter.",
        'parameter.*.min'=>"Parameter should be between 1 and 50 characters.",
        'parameter.*.max'=>"Parameter should be between 1 and 50 characters.",
        'price.*.required'=>"Please enter a price.",
        'price.*.numeric'=>"Please enter a valid price.",
        'price.*.min'=>"Price should be between 1 and 999999.",
        'price.*.max'=>"Price should be between 1 and 999999.",


      ];
    }
}
