<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Message;

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
        if (in_array($value, Message::VALID_SUBJECTS)) {
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
        return 'Temat wiadomości był niedozwolony.';
    }
}
