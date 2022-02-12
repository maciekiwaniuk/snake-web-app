<?php

namespace Tests\Feature\UserTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Message;
use App\Models\User;

class UserHandlesActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_change_password_in_options_tab()
    {
        $user = User::factory()->create(['password' => Hash::make(config('auth.default_password'))]);

        $response = $this->actingAs($user)->put(
            route('options.password-change'),
            [
                'old_password' => config('auth.default_password'),
                'new_password' => 'new_example_password',
                'new_password_confirmation' => 'new_example_password'
            ]
        );

        $response->assertStatus(302)->assertSessionHas('password_success');
        $this->assertNotEquals($user->password, Hash::make(config('auth.default_password')));
    }

    public function test_user_can_change_email_in_options_tab()
    {
        $user = User::factory()->create([
            'password' => Hash::make(config('auth.default_password')),
            'email' => 'email@example.test'
        ]);

        $response = $this->actingAs($user)->put(
            route('options.email-change'),
            [
                'old_password' => config('auth.default_password'),
                'new_email' => 'new_email@example.test',
                'new_email_confirmation' => 'new_email@example.test'
            ]
        );

        $response->assertStatus(302)->assertSessionHas('email_success');
        $this->assertNotEquals($user->email, 'email@example.test');
    }

    public function test_user_can_delete_his_avatar_in_options_tab()
    {
        $example_avatar_path = 'example_avatar_path/file.png';
        $user = User::factory()->create(['avatar_path' => $example_avatar_path]);

        $response = $this->actingAs($user)->delete(route('options.avatar-delete'));

        // get the returned result response json value
        $result = json_decode(json_encode($response), true)['baseResponse']['original']['result'];

        $this->assertTrue($result['success']);
        $this->assertNotEquals($user->avatar_path, $example_avatar_path);
    }

    public function test_user_can_delete_his_account_in_options_tab()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create(['password' => Hash::make(config('auth.default_password'))]);

        $response = $this->actingAs($user)->delete(
            route('options.account-delete'),
            [
                'password' => config('auth.default_password')
            ]
        );

        try {
            $user_deleted = User::findOrFail($user->id);
            $this->assertTrue(false);
        } catch (ModelNotFoundException $error) {
            $this->assertTrue(true);

        }
    }

    public function test_user_can_logout_from_game_on_all_devices_in_options_tab()
    {
        $user = User::factory()->create();
        $api_token_before_reset = $user->api_token;

        $response = $this->actingAs($user)->post(route('options.logout-from-game'));

        $result = json_decode(json_encode($response), true)['baseResponse']['original']['result'];

        $this->assertTrue($result['success']);
        $this->assertNotEquals($user->api_token, $api_token_before_reset);
    }

    public function test_user_can_logout_from_website_on_other_devices_in_options_tab()
    {
        $user = User::factory()->create(['password' => Hash::make(config('auth.default_password'))]);

        $response = $this->actingAs($user)->post(
            route('options.logout-from-website'),
            [
                'password' => config('auth.default_password')
            ]
        );

        $result = json_decode(json_encode($response), true)['baseResponse']['original']['result'];

        $this->assertTrue($result['success']);
    }

    public function test_user_can_change_visibility_of_his_profile()
    {
        $user_public = User::factory()->create(['profile_visibility_status' => 'public']);
        $this->actingAs($user_public)->post(
            route('profile.options.change-profile-visibility-status'),
            [
                'status' => 'private'
            ]
        );
        $this->assertEquals($user_public->profile_visibility_status, 'private');
    }

    public function test_user_can_send_messages()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(
            route('message.store'),
            [
                'subject' => 'contact',
                'sender' => 'Joe',
                'email' => 'test@example.com',
                'content' => 'Lorem ipsum...',
                'sent_as_user' => false
            ]
        );

        try {
            $message = Message::firstOrFail();
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
    }

    public function test_user_can_send_ajax_messages()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(
            route('message.store-AJAX'),
            [
                'subject' => 'contact',
                'sender' => 'Joe',
                'email' => 'test@example.com',
                'content' => 'Lorem ipsum...',
                'sent_as_user' => true
            ]
        );

        try {
            $message = Message::firstOrFail();
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
    }

}
