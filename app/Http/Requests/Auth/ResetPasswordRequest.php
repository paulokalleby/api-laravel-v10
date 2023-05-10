<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'token'    => ['required'],
            'email'    => ['required', 'string' ,'email'],
            'password' => ['required', 'string', 'min:6', 'max:16'],
        ];
    }
}
