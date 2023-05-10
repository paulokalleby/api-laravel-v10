<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name'     => ['required', 'string', 'min:3', 'max:50'],
            'password' => ['required', 'string' ,'min:6', 'max:16'],
            'email'    => ['required', 'string','email', 'max:255', "unique:users,email,{$this->user},id"],
        ];

        if($this->method() == 'PUT') {
            $rules['password'] = ['nullable','string', 'min:6', 'max:16'];
        }

        return $rules;
    }
    
}
