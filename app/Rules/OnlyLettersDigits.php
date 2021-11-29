<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;


class OnlyLettersDigits implements Rule
{
    /**
     * Determine if the validation rule passes.

     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (preg_match('/^[a-zA-Z0-9żźćńółęąśŻŹĆĄŚĘŁÓŃ]*$/', $value)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute zawierała niedozwolone znaki.';
    }
}
