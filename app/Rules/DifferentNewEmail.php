<?php

namespace App\Rules;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

class DifferentNewEmail implements Rule
{

    public function passes($attribute, $value)
    {
        if ($value == Auth::user()->email) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'Nowy email był taki sam jak aktualny.';
    }
}
