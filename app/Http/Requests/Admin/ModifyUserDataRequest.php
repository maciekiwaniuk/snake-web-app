<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;


class ModifyUserDataRequest extends FormRequest
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
            'name' => ['bail', 'nullable', 'unique:users,name', 'max:100'],
            'email' => ['bail', 'nullable', 'email', 'unique:users,email', 'max:100'],
            'password' => ['bail', 'nullable', 'max:100']
        ];
    }

}
