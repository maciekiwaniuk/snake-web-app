<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OnlyLettersDigits implements Rule
{
    public function passes($attribute, $value)
    {
        if (preg_match('/^[a-zA-Z0-9żźćńółęąśŻŹĆĄŚĘŁÓŃ]*$/', $value)) {
            return true;
        }
        return false;
    }

    public function message()
    {
        return ':attribute zawierała niedozwolone znaki.';
    }
}
