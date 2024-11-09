<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Message;

class MessageSubject implements Rule
{
    public function passes($attribute, $value)
    {
        if (in_array($value, Message::VALID_SUBJECTS)) {
            return true;
        }
        return false;
    }

    public function message()
    {
        return 'Temat wiadomości był niedozwolony.';
    }
}
