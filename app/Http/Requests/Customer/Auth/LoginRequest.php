<?php

namespace App\Http\Requests\Customer\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class LoginRequest extends FormRequest
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
            'email' => ['bail', 'required', 'email', Rule::exists('users')->where(function($q) {
                        $q->where('role', 5)->where(['status'=> 1, 'deleted_at'=>null]);
                    })],
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Please enter E-mail.',
            'email.email' => 'Please enter a valid E-Mail.',
            'email.exists' => 'Please enter valid credentials.',
            'password.required' => 'Please enter Password.',
        ];
    }
}
