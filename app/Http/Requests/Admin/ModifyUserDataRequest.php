<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ModifyUserDataRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['bail', 'nullable', 'unique:users,name', 'max:100'],
            'email' => ['bail', 'nullable', 'email', 'unique:users,email', 'max:100'],
            'password' => ['bail', 'nullable', 'max:100']
        ];
    }

}
