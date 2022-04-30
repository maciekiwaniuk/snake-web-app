<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class reCAPTCHAv2 implements Rule
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
        if (!env('CAPTCHA_VALIDATION_ENABLED')) {
            return true;
        }

        $secret_key_recaptcha_v2 = env('CAPTCHA_SECRET_KEY');
        $recaptcha_check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key_recaptcha_v2.'&response='.$value);
        $recaptcha_response = json_decode($recaptcha_check);

        if ($recaptcha_response->success) {
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
        return 'reCAPTCHA jest wymagana.';
    }
}
