<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetLinkRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'E-mail jest wymagany.',
            'email.email' => 'E-mail musi być poprawnym adresem E-mail.'
        ];
    }
}
