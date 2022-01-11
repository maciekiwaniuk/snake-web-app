<?php

namespace Tests\Feature\UserTests;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserHandlesActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_change_password_in_options_tab()
    {
        $user = User::factory()->create();
        $user->password = Hash::make(config('auth.default_password'));
        $user->save();

        $response = $this->actingAs($user)->put(
            route('options.password-change'),
            [
                'old_password' => config('auth.default_password'),
                'new_password' => 'new_example_password',
                'new_password_confirmation' => 'new_example_password'
            ]
        );

        $response->assertStatus(302)->assertSessionHas('password_success');
    }

    public function test_user_can_change_email_in_options_tab()
    {
        $user = User::factory()->create();
        $user->password = Hash::make(config('auth.default_password'));
        $user->save();

        $response = $this->actingAs($user)->put(
            route('options.email-change'),
            [
                'old_password' => config('auth.default_password'),
                'new_email' => 'new_email@example.test',
                'new_email_confirmation' => 'new_email@example.test'
            ]
        );

        $response->assertStatus(302)->assertSessionHas('email_success');
    }

    public function test_user_can_delete_his_avatar_in_options_tab()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('options.avatar-delete'));

        // get the returned result response json value
        $result = json_decode(json_encode($response), true)['baseResponse']['original']['result'];

        $this->assertTrue($result['success']);
    }

    public function test_user_can_delete_his_account_in_options_tab()
    {
        $user = User::factory()->create();
        $user->password = Hash::make(config('auth.default_password'));
        $user->save();

        $response = $this->actingAs($user)->delete(
            route('options.account-delete'),
            [
                'password' => config('auth.default_password')
            ]
        );

        $result = json_decode(json_encode($response), true)['baseResponse']['original']['result'];

        $this->assertFalse($result['error']);
    }

    public function test_user_can_logout_from_game_on_all_devices_in_options_tab()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('options.logout-from-game'));

        $result = json_decode(json_encode($response), true)['baseResponse']['original']['result'];

        $this->assertTrue($result['success']);
    }

    public function test_user_can_logout_from_website_on_other_devices_in_options_tab()
    {
        $user = User::factory()->create();
        $user->password = Hash::make(config('auth.default_password'));
        $user->save();

        $response = $this->actingAs($user)->post(
            route('options.logout-from-website'),
            [
                'password' => config('auth.default_password')
            ]
        );

        $result = json_decode(json_encode($response), true)['baseResponse']['original']['result'];

        $this->assertTrue($result['success']);
    }

}
