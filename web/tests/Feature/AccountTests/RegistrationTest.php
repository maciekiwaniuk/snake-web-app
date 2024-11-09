<?php

namespace Tests\Feature\AccountTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use App\Models\UserGameData;
use App\Rules\ValidNickname;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post(route('register'), [
            'name' => 'TestUser',
            'email' => 'test@example.com',
            'password' => config('auth.default_password'),
            'password_confirmation' => config('auth.default_password'),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home'));
    }

    public function test_game_data_creation_after_registration()
    {
        $this->post(route('register'), [
            'name' => 'TestUser',
            'email' => 'test@example.com',
            'password' => config('auth.default_password'),
            'password_confirmation' => config('auth.default_password'),
        ]);

        try {
            $user = User::firstOrFail();
            $user_game_data = UserGameData::findOrFail($user->id);
            $this->assertTrue(true);
        } catch (ModelNotFoundException $error) {
            $this->assertTrue(false);
        }
    }

    public function test_user_cant_register_with_abusive_nickname()
    {
        $this->post(route('register'), [
            'name' => array_rand(ValidNickname::ABUSIVE_WORDS),
            'email' => 'test@example.com',
            'password' => config('auth.default_password'),
            'password_confirmation' => config('auth.default_password'),
        ]);

        try {
            $user = User::firstOrFail();
            $this->assertTrue(false);
        } catch (ModelNotFoundException $error) {
            $this->assertTrue(true);
        }
    }
}
