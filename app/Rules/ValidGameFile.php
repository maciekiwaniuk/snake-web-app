<?php

namespace App\Rules;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

class ValidGameFile implements Rule
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
        if ($value->getClientOriginalExtension() != 'json') {
            return false;
        }

        $content = json_decode(file_get_contents($value), true);

        if (!$this->validFileContent($content)) {
            return false;
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
        return 'Wystąpił podczas wczytywania postępu gry.';
    }

    /**
     * VALID FILE CONTENT
     */
    protected function validFileContent($content)
    {
        if ($this->validCoins($content) && $this->validSelectedLevel($content) &&
            $this->validSelectedSkins($content) && $this->validDifficulties($content) &&
            $this->validRecords($content))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Valid coins property
     */
    protected function validCoins($content)
    {
        if (isset($content['coins']) && is_int($content['coins']) &&
            $content['coins'] >= 0 && $content['coins'] <= 100_000)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Valid selected_level property
     */
    protected function validSelectedLevel($content)
    {
        if (isset($content['selected_level']) && is_string($content['selected_level']) &&
            ( $content['selected_level'] == "easy" || $content['selected_level'] == "medium" ||
              $content['selected_level'] == "hard" ) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Valid selected_skins property
     */
    protected function validSelectedSkins($content)
    {
        if (isset($content['selected_skins']) && isset($content['selected_skins']['snake']) &&
            isset($content['selected_skins']['fruit']) && isset($content['selected_skins']['board']) &&
            is_string($content['selected_skins']['snake']) && is_string($content['selected_skins']['fruit']) &&
            is_string($content['selected_skins']['board']) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Valid difficulties property
     */
    protected function validDifficulties($content)
    {
        if (isset($content['difficulties']) && isset($content['difficulties']['medium']) &&
            isset($content['difficulties']['hard']) && is_bool($content['difficulties']['medium']) &&
            is_bool($content['difficulties']['hard']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Valid records property
     */
    protected function validRecords($content)
    {
        if (isset($content['records']) && isset($content['records']['easy']) &&
            isset($content['records']['medium']) && isset($content['records']['hard']) &&
            is_int($content['records']['easy']) && is_int($content['records']['medium']) &&
            is_int($content['records']['hard']) && $content['records']['easy'] >= 0 &&
            $content['records']['easy'] <= 200 && $content['records']['medium'] >= 0 &&
            $content['records']['medium'] <= 200 && $content['records']['hard'] >= 0 &&
            $content['records']['hard'] <= 200)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Valid inventory property
     */
    protected function validInventory($content)
    {

    }
}
