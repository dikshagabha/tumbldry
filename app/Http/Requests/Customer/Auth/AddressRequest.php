<?php

namespace App\Http\Requests\Customer\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Rules\{
    //PasswordPattern,
    //DisallowSpaces,
    CheckName
};

class AddressRequest extends FormRequest
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
            'address' => 'bail|required|string|max:500',
            'city' => 'bail|required|max:255',
            'state' => 'bail|required|max:255',
            'pin' => 'bail|required|min:1|max:15',
            'landmark' => 'bail|nullable|string|max:500',
            'latitude' => 'bail|nullable|numeric|min:-90|max:90',
            'longitude' => 'bail|nullable|numeric|min:-180|max:180',
        ];
       
    }
}
