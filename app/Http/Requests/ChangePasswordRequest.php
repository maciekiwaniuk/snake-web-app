<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\LoggedUserPassword;
use App\Rules\DifferentNewPassword;


class ChangePasswordRequest extends FormRequest
{
    /**
     * Name of error Bag
     *
     * @return string
     */
    protected $errorBag = 'password';


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
            'new_password' => [
                'bail',
                'required',
                'min:8',
                'confirmed',
                new DifferentNewPassword,
            ],
        ];
    }

    /**
     * Get the URL to redirect to on a validation error.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        return route('options.selected', 'haslo');
    }
}
