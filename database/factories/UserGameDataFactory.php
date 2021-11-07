<?php

namespace Database\Factories;

use App\Models\UserGameData;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserGameDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserGameData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all();
        return [
            'user_id' => $this->faker->unique()->numberBetween(1, $users->count()),

            'points' => rand(1, 100000),
            'coins' => rand(1, 100000),
            'play_time_seconds' => rand(1, 86400),

            'easy_record' => rand(1, 90),
            'medium_record' => rand(1, 90),
            'hard_record' => rand(1, 90),
            'speed_record' => rand(1, 90),

            'games_amount' => rand(1, 1000),
            'ate_fruits_amount' => rand(1, 10000),
            'hit_wall' => rand(1, 500),
            'hit_snake' => rand(1, 500),
            'clicks' => rand(1, 100000),

            'unlocked_medium' => true,
            'unlocked_hard' => true,
            'unlocked_speed' => true,
        ];
    }
}
