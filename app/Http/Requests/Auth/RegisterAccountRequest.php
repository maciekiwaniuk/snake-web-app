<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use App\Rules\OnlyLettersDigits;
use App\Rules\ValidNickname;
use App\Rules\reCAPTCHAv2;

class RegisterAccountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:30', 'unique:users', new OnlyLettersDigits, new ValidNickname],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'g-recaptcha-response' => [new reCAPTCHAv2],
        ];
    }

    public function messages()
    {
        return [
            'password.confirmed' => 'Hasła nie były takie same.'
        ];
    }
}
