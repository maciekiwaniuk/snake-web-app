<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MessageSubject;
use App\Rules\reCAPTCHAv2;

class MessageAjaxRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subject' => ['required', 'string', 'max:100', new MessageSubject],
            'sender' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'content' => ['required', 'string', 'max:500'],
            'g_recaptcha_response' => [new reCAPTCHAv2]
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'E-mail jest niepoprawny.',
            'sender.required' => 'Twoja nazwa jest wymagana.',
            'email.required' => 'Twój e-mail jest wymagany.',
            'content.required' => 'Treść wiadomości jest wymagana.'
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
