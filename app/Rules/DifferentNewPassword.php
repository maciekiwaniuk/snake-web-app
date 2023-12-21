<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DifferentNewPassword implements Rule
{

    public function passes($attribute, $value)
    {
        if (Hash::check($value, Auth::user()->password)) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'Nowe hasło musi się różnić od aktualnego.';
    }
}
