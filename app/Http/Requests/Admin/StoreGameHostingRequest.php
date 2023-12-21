<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameHostingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'link' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nazwa hostingu jest wymagana.',
            'link.required' => 'Link do pobrania jest wymagmany.'
        ];
    }

}
