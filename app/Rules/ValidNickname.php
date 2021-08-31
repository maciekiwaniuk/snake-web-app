<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;


class ValidNickname implements Rule
{
    /**
     * Determine if the validation rule passes.

     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $uncensored_words_string = file_get_contents('assets/uncensored_words.json');
        $words_json = json_decode($uncensored_words_string, true);

        foreach ($words_json as $word) {
            if (preg_match("/".$word."/i", strtolower($value))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute zawierała nieodpowiednie słownictwo.';
    }
}
