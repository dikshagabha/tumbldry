<?php

namespace App\Http\Requests\Runner\Auth;
use Illuminate\Http\Request;
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
    public function rules(Request $request)
    {
	//dd($request->input('email'));
        return [
            'email' => ['bail', 'email', Rule::exists('users')->where(function($q) {
                        $q->where('role', 5)->where('status', 1);
                    })],
            'phone_number'=>['bail', 'numeric', Rule::exists('users')->where(function($q) {
                        $q->where('role', 5)->where('status', 1);
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
