<?php

namespace App\Http\Requests\Store;

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
                        $q->where('role', 3)->where(['status'=> 1, , 'deleted_at'=>null]);
                    })],
            'password' => 'required',
        ];
    }
}
