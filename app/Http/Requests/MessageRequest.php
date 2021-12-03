<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\reCAPTCHAv2;
use App\Rules\MessageSubject;

class MessageRequest extends FormRequest
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
            'g-recaptcha-response' => [new reCAPTCHAv2]
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
            'subject.required' => 'Temat wiadomości jest wymagany.',
            'subject.max' => 'Temat wiadomości może posiadać maksymalnie 100 znaków.',
            'sender.required'=> 'Nadawca wiadomości jest wymagany.',
            'sender.max' => 'Nadawca może zawierać maksymalnie 100 znaków.',
            'content.required' => 'Treść wiadomości jest wymagana.',
            'content.max' => 'Treść wiadomości może posiadać maksymalnie 500 znaków.'
        ];
    }
}
