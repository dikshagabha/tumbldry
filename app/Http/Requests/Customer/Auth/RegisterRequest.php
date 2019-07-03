<?php

namespace App\Http\Requests\Customer\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Rules\{
    //PasswordPattern,
    //DisallowSpaces,
    CheckName
};

class RegisterRequest extends FormRequest
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
            
            'name' => ['bail', 'required', 'string', 'min:2', 'max:25', new CheckName],
            
            'email' => ['bail', 'nullable', 'email', 'max:120', Rule::unique('users', 'email')
                ->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            
            'phone_number' => ['bail', 'required', 'numeric', 'digits_between:8,15', Rule::unique('users', 'phone_number')
                ->where(function ($query) {
                    $query->where('deleted_at', null)->where('role', 3);
                })
            ],
            // 'address' => 'bail|required|string|max:500',
            // 'city' => 'bail|required|max:255',
            // 'state' => 'bail|required|max:255',
            // 'pin' => 'bail|required|min:1|max:15',
            // 'landmark' => 'bail|nullable|string|max:500',
            
            // //'password' => ['bail', 'required', 'min:8', 'max:30', new DisallowSpaces, 'confirmed'],
            // 'latitude' => 'bail|nullable|numeric|min:-90|max:90',w
            // 'longitude' => 'bail|nullable|numeric|min:-180|max:180',
        ];
       
    }
}
