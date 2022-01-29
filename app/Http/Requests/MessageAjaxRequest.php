<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MessageSubject;
use App\Rules\reCAPTCHAv2;

class MessageAjaxRequest extends FormRequest
{
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
            'subject' => ['required', 'string', 'max:100', new MessageSubject],
            'sender' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'content' => ['required', 'string', 'max:500'],
            'g_recaptcha_response' => [new reCAPTCHAv2]
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
            'email.email' => 'E-mail jest niepoprawny.',
            'sender.required' => 'Twoja nazwa jest wymagana.',
            'email.required' => 'Twój e-mail jest wymagany.',
            'content.required' => 'Treść wiadomości jest wymagana.'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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
