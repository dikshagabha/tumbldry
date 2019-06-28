<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PlansRequest extends FormRequest
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
              //'address_id'=>['bail','required', 'numeric'],
              'description'=>['bail','required', 'string','min:2', 'max:200'],
              'type'=>['bail', 'required', 'numeric'],
              'price'=>['bail','numeric', 'min:2', 'max:999999'],
              'end_date'=>['bail','numeric', 'min:1', 'max:99'],
            ];
    }

    public function messages()
    {
      return [

        'end_date.required'=>"Please select an duration.",
        'end_date.numeric'=>"Please enter a valid duration.",
        'end_date.min'=>"Duration must be between 1 to 99.",
        'end_date.max'=>"Duration must be between 1 to 99.",
      ];
    }
}
