<?php

namespace Tests\Feature\AccountTests;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
}
