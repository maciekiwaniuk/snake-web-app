<?php

namespace Tests\Feature\AdminTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\GameHosting;
use App\Models\User;
use App\Models\VisitorUnique;

class AdminHandlesActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_user_account()
    {
        $this->withoutExceptionHandling();
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.delete-account', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');

        try {
            $user_deleted = User::findOrFail($user->id);
            $this->assertTrue(false);
        } catch (ModelNotFoundException $error) {
            $this->assertTrue(true);

        }
    }

    public function test_admin_can_ban_user_account()
    {
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->put(route('admin.ban-account', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');

        $user_after_ban = User::where('id', '=', $user->id)->first();
        $this->assertEquals($user_after_ban->user_banned, User::BANNED);
    }

    public function test_admin_can_unban_user_account()
    {
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);
        $user = User::factory()->create(['user_banned' => User::BANNED]);

        $response = $this->actingAs($admin)->put(route('admin.unban-account', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');

        $user_after_unban = User::where('id', '=', $user->id)->first();
        $this->assertEquals($user_after_unban->user_banned, User::NOT_BANNED);
    }

    public function test_admin_can_ban_user_last_ip()
    {
        $user = User::factory()->create();
        $ip = VisitorUnique::factory()->create(['ip' => $user->last_login_ip]);
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);

        $response = $this->actingAs($admin)->put(route('admin.ban-last-ip', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');

        $user_last_ip_after_ban = VisitorUnique::where('id', '=', $ip->id)->first();
        $this->assertEquals($user_last_ip_after_ban->ip_banned, VisitorUnique::BANNED);
    }

    public function test_admin_can_unban_user_last_ip()
    {
        $user = User::factory()->create();
        $ip = VisitorUnique::factory()->create(['ip_banned' => VisitorUnique::BANNED, 'ip' => $user->last_login_ip]);
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);

        $response = $this->actingAs($admin)->put(route('admin.unban-last-ip', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');

        $user_last_ip_after_unban = VisitorUnique::where('id', '=', $ip->id)->first();
        $this->assertEquals($user_last_ip_after_unban->ip_banned, VisitorUnique::NOT_BANNED);
    }

    public function test_admin_can_ban_user_account_and_ip()
    {
        $user = User::factory()->create();
        $ip = VisitorUnique::factory()->create(['ip' => $user->last_login_ip]);
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);

        $response = $this->actingAs($admin)->put(route('admin.ban-last-ip-account', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');

        $ip_after_ban = VisitorUnique::where('id', '=', $ip->id)->first();
        $user_after_ban = User::where('id', '=', $user->id)->first();

        $this->assertEquals($ip_after_ban->ip_banned, VisitorUnique::BANNED);
        $this->assertEquals($user_after_ban->user_banned, User::BANNED);
    }

    public function test_admin_can_unban_user_account_and_ip()
    {
        $user = User::factory()->create(['user_banned' => User::BANNED]);
        $ip = VisitorUnique::factory()->create(['ip_banned' => VisitorUnique::BANNED, 'ip' => $user->last_login_ip]);
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);

        $response = $this->actingAs($admin)->put(route('admin.unban-last-ip-account', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');

        $ip_after_unban = VisitorUnique::where('id', '=', $ip->id)->first();
        $user_after_unban = User::where('id', '=', $user->id)->first();

        $this->assertEquals($ip_after_unban->ip_banned, VisitorUnique::NOT_BANNED);
        $this->assertEquals($user_after_unban->user_banned, User::NOT_BANNED);
    }

    public function test_admin_can_reset_api_token_for_user()
    {
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->put(route('admin.reset-api-token', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');

        $user_after_token_reset = User::where('id', '=', $user->id)->first();
        $this->assertNotEquals($user_after_token_reset->api_token, $user->api_token);
    }

    public function test_admin_can_delete_avatar_for_user()
    {
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);
        $user = User::factory()->create(['avatar_path' => '/example_avatar_path/avatar.png']);

        $response = $this->actingAs($admin)->delete(route('admin.delete-avatar', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');

        $user_after_deleted_avatar = User::where('id', '=', $user->id)->first();
        $this->assertNotEquals($user_after_deleted_avatar->avatar_path, $user->avatar_path);
    }

    public function test_admin_can_change_name_email_password_for_user()
    {
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);
        $user_before_change = User::factory()->create();

        $response = $this->actingAs($admin)->put(
            route('admin.modify-data', $user_before_change->id),
            [
                'name' => 'new_user_name',
                'email' => 'new_user_email@example.test',
                'password' => 'new_user_password'
            ]
        );

        $user_after_change = User::find($user_before_change->id);

        $response->assertStatus(302)->assertSessionHas('success');
        $this->assertEquals($user_after_change->name, 'new_user_name');
        $this->assertEquals($user_after_change->email, 'new_user_email@example.test');
        $this->assertNotEquals($user_before_change->password, $user_after_change->password);
    }

    public function test_admin_can_ban_specified_ip()
    {
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);
        $ip = VisitorUnique::factory()->create();

        $response = $this->actingAs($admin)->put(route('admin.ban-ip', $ip->id));
        $response->assertStatus(302)->assertSessionHas('success');

        $ip_after_ban = VisitorUnique::where('id', '=', $ip->id)->first();
        $this->assertEquals($ip_after_ban->ip_banned, VisitorUnique::BANNED);
    }

    public function test_admin_can_unban_specified_ip()
    {
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);
        $ip = VisitorUnique::factory()->create(['ip_banned' => VisitorUnique::BANNED]);

        $response = $this->actingAs($admin)->put(route('admin.unban-ip', $ip->id));
        $response->assertStatus(302)->assertSessionHas('success');

        $ip_after_unban = VisitorUnique::where('id', '=', $ip->id)->first();
        $this->assertEquals($ip_after_unban->ip_banned, VisitorUnique::NOT_BANNED);
    }

    public function test_admin_can_add_game_hosting()
    {
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);

        $this->actingAs($admin)->post(
            route('admin.game-hostings.store'),
            [
                'name' => 'Example hosting',
                'link' => 'https://github.com/maciekiwaniuk/snake-web-app'
            ]
        );

        try {
            $game_hosting = GameHosting::firstOrFail();
            $this->assertTrue(true);
        } catch (\Exception $exception) {
            $this->assertTrue(false);
        }
    }

    public function test_admin_can_modify_game_hosting()
    {
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);
        $game_hosting = GameHosting::factory()->create();

        $example_hosting_name = 'Example hosting';
        $example_hosting_link = 'https://github.com/maciekiwaniuk/snake-web-app';

        $this->actingAs($admin)->put(
            route('admin.game-hostings.update', $game_hosting->id),
            [
                'name' => $example_hosting_name,
                'link' => $example_hosting_link
            ]
        );

        $modified_game_hosting = GameHosting::first();

        $this->assertEquals($modified_game_hosting->name, $example_hosting_name);
        $this->assertEquals($modified_game_hosting->link, $example_hosting_link);
    }

    public function test_admin_can_delete_game_hosting()
    {
        $admin = User::factory()->create(['permission' => User::ADMIN_PERMISSION]);
        $game_hosting = GameHosting::factory()->create();

        $this->actingAs($admin)->delete(
            route('admin.game-hostings.destroy', $game_hosting->id)
        );

        try {
            $game_hosting = GameHosting::firstOrFail();
            $this->assertTrue(false);
        } catch (\Exception $exception) {
            $this->assertTrue(true);
        }
    }

}
