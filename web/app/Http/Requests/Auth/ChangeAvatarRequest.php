<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ChangeAvatarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => ['image', 'mimes:jpeg,jpg,png', 'max:10000', 'dimensions:max_width=800,max_height=800']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $result = [
            'message' => $validator->errors()->first(),
        ];

        throw new HttpResponseException(response()->json([
            'result' => $result
        ]));
    }
}
