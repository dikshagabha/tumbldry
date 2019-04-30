<?php

namespace App\Http\Requests\Admin;
use Illuminate\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreRateCard extends FormRequest
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
      if ($request->type==1) {
          if ($request->city=="global") {
            return [
              'city' => 'bail|required|string',
              'service' => 'bail|required|string',
              'parameter'=>['bail', 'required', 'array', 'min:1'],
                    'parameter.*'=>['bail', 'required', 'string', 'min:1', 'max:50'],
                    'price'=>['bail', 'required', 'array', 'min:1'],
                    'price.*'=>['bail', 'required', 'numeric', 'min:1', 'max:999999'],
                    'quantity'=>['bail', 'required', 'array', 'min:1'],
                    'quantity.*'=>['bail', 'required', 'numeric', 'min:1', 'max:999999'],
                ];
            }

            return [
                'bsp'=>'bail|required|numeric|min:1|max:100',
                'operator'=>'bail|required|numeric|min:0|max:1',
                'city' => 'bail|required|string',
                'service' => 'bail|required|string',
            ];
               
        }
        else{
           if ($request->city=="global") {
            return [
              'city' => 'bail|required|string',
              'service' => 'bail|required|string',
              'parameter'=>['bail', 'required', 'array', 'min:1'],
              'parameter.*'=>['bail', 'required', 'string', 'min:1', 'max:50'],
              'price'=>['bail', 'required', 'array', 'min:1'],
              'price.*'=>['bail', 'required', 'numeric', 'min:1', 'max:999999'],
            ];
          };

          return [
          'bsp'=>'bail|required|numeric|min:1|max:100',
          'operator'=>'bail|required|numeric|min:0|max:1',
          'city' => 'bail|required|string',
          'service' => 'bail|required|string',
          ];
        };
        
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
        
        'quantity.*.required'=>"Please enter a quantity.",
        'quantity.*.numeric'=>"Please enter a valid quantity.",
        'quantity.*.min'=>"Quantity should be between 1 and 999999.",
        'quantity.*.max'=>"Quantity should be between 1 and 999999.",


      ];
    }
}
