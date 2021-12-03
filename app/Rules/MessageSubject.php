<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MessageSubject implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $subjects = [
            'contact',
            'error-website',
            'error-game',
            'other'
        ];

        if (in_array($value, $subjects)) {
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
        return 'Temat wiadomość był niedozwolony.';
    }
}
