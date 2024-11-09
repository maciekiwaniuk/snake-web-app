<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class reCAPTCHAv2 implements Rule
{
    public function passes($attribute, $value)
    {
        if (!config('captcha.enabled')) {
            return true;
        }

        $secret_key_recaptcha_v2 = config('features.captcha.private_key');
        $recaptcha_check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key_recaptcha_v2.'&response='.$value);
        $recaptcha_response = json_decode($recaptcha_check);

        if ($recaptcha_response->success) {
            return true;
        }
        return false;
    }

    public function message()
    {
        return 'reCAPTCHA jest wymagana.';
    }
}
