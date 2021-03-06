<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

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
            'name' => $this->faker->unique()->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make(config('auth.default_password')),
            'api_token' => Str::random(60),
            'avatar_path' => '/assets/images/avatar.png',
            'permission' => User::USER_PERMISSION,
            'last_login_ip' => $this->generateRandomIP(),
            'last_login_time' => Carbon::now()->subMinutes(rand(1, 2440)),
            'last_user_agent' => substr($this->getUserAgent(), 0, 200),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'profile_visibility_status' => 'public'
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
