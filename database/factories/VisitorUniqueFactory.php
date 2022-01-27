<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\VisitorUnique;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0";
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ip_banned' => 0,
            'user_agent' => $this->getUserAgent(),
            'ip' => \App\Models\User::factory()->create()->last_login_ip,
        ];
    }
}
