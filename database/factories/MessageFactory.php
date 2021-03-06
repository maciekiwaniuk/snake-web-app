<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Message;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subject' => 'contact',
            'sender' => 'Nadawca',
            'email' => 'email@test.com',
            'content' => 'Przykładowa treść wiadomości.',
            'sent_as_user' => false
        ];
    }
}
