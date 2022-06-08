<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidNickname implements Rule
{
    /**
     * Abusive words which can not be used in user's nickname
     */
    const ABUSIVE_WORDS = [
        'admin',
        'moderator'
    ];

    /**
     * Determine if the validation rule passes.

     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $abusive_words = self::ABUSIVE_WORDS;

        // check if directory exists for feature test
        if (file_exists('assets/uncensored_words.json')) {
            $uncensored_words_string = file_get_contents('assets/uncensored_words.json');
            $words_from_file = json_decode($uncensored_words_string, true);

            $abusive_words = array_merge($abusive_words, $words_from_file);
        }

        $digits = [
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
        ];
        $letters = [
            'o', 'i', 'z', 'e', 'a', 's', 'g', 't', 'b', 'p'
        ];

        $value_replaced_digits = str_replace($digits, $letters, $value);

        // check if name contains abusive word in it self
        foreach ($abusive_words as $word) {
            if (preg_match('/'.$word.'/i', strtolower($value)) ||
                preg_match('/'.$word.'/i', strtolower($value_replaced_digits))) {
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
