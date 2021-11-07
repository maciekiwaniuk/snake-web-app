<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\LoggedUserPassword;
use App\Rules\DifferentNewEmail;


class ChangeEmailRequest extends FormRequest
{
    /**
     * Name of error Bag
     *
     * @return string
     */
    protected $errorBag = 'email';


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

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'new_email.required' => 'Nowy email jest wymagany.',
            'new_email.email' => 'Nowy email nie był poprawny.',
            'new_email.confirmed' => 'Emaile różniły się od siebie.',
            'new_email.unique' => 'Podany email należy już do innego użytkownika.',
        ];
    }

    /**
     * Get the URL to redirect to on a validation error.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        return route('options.show', 'email');
    }
}
