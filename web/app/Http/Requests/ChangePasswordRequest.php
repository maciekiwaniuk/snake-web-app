<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\LoggedUserPassword;
use App\Rules\DifferentNewPassword;


class ChangePasswordRequest extends FormRequest
{

    protected $errorBag = 'password';

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'old_password' => [
                'bail',
                'required',
                new LoggedUserPassword,
            ],
            'new_password' => [
                'bail',
                'required',
                'min:8',
                'confirmed',
                new DifferentNewPassword,
            ],
        ];
    }

    protected function getRedirectUrl()
    {
        return route('options.show', 'haslo');
    }

    public function messages()
    {
        return ['new_password.confirmed' => 'Pola z nowym hasłem różniły się do siebie.'];
    }
}
