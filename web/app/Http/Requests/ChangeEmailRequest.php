<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\LoggedUserPassword;
use App\Rules\DifferentNewEmail;


class ChangeEmailRequest extends FormRequest
{
    protected $errorBag = 'email';

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
            'new_email' => [
                'bail',
                'required',
                'email',
                'confirmed',
                'unique:users,email',
                new DifferentNewEmail,
            ],
        ];
    }

    public function messages()
    {
        return [
            'new_email.required' => 'Nowy email jest wymagany.',
            'new_email.email' => 'Nowy email nie był poprawny.',
            'new_email.confirmed' => 'Emaile różniły się od siebie.',
            'new_email.unique' => 'Podany email należy już do innego użytkownika.',
        ];
    }

    protected function getRedirectUrl()
    {
        return route('options.show', 'email');
    }
}
