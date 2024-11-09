<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\VisitorUnique;

class VisitorUniqueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VisitorUnique::class;

    /**
     * Get User Agent string
     */
    public function getUserAgent()
    {
        return 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0';
    }

    /**
     * Generate random ip adress
     */
    public function generateRandomIP()
    {
        $num1 = rand(0, 255);
        $num2 = rand(0, 255);
        $num3 = rand(0, 255);
        $num4 = rand(0, 255);
        return $num1.'.'.$num2.'.'.$num3.'.'.$num4;
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ip_banned' => false,
            'user_agent' => substr($this->getUserAgent(), 0, 200),
            'ip' => $this->generateRandomIP(),
        ];
    }
}
