<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\LoggedUserPassword;

class LogoutFromOtherDevicesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password' => ['bail', 'required', new LoggedUserPassword]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $result = [
            'error' => true,
            'message' => $validator->errors()->first(),
        ];

        throw new HttpResponseException(response()->json([
            'result' => $result
        ]));
    }
}
