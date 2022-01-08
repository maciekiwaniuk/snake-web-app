<?php

namespace Tests\Feature\AdminTests;

use App\Models\User;
use App\Models\VisitorUnique;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminHandleActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_user_account()
    {
        $admin = User::factory()->create(['permission' => 2]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.delete-account', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');
    }

    public function test_admin_can_ban_user_account()
    {
        $admin = User::factory()->create(['permission' => 2]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->put(route('admin.ban-account', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');
    }

    public function test_admin_can_unban_user_account()
    {
        $admin = User::factory()->create(['permission' => 2]);
        $user = User::factory()->create(['user_banned' => 1]);

        $response = $this->actingAs($admin)->put(route('admin.unban-account', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');
    }

    public function test_admin_can_ban_user_last_ip()
    {
        VisitorUnique::factory()->create();
        $admin = User::factory()->create(['permission' => 2]);
        $user = User::first();

        $response = $this->actingAs($admin)->put(route('admin.ban-last-ip', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');
    }

    public function test_admin_can_unban_user_last_ip()
    {
        VisitorUnique::factory()->create(['ip_banned' => 1]);
        $admin = User::factory()->create(['permission' => 2]);
        $user = User::first();

        $response = $this->actingAs($admin)->put(route('admin.unban-last-ip', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');
    }

    public function test_admin_can_ban_user_account_and_ip()
    {
        VisitorUnique::factory()->create();
        $admin = User::factory()->create(['permission' => 2]);
        $user = User::first();

        $response = $this->actingAs($admin)->put(route('admin.ban-last-ip-account', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');

    }

    public function test_admin_can_unban_user_account_and_ip()
    {
        VisitorUnique::factory()->create(['ip_banned' => 1]);
        $admin = User::factory()->create(['permission' => 2]);
        $user = User::first();
        $user->user_banned = 1;
        $user->save();

        $response = $this->actingAs($admin)->put(route('admin.unban-last-ip-account', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');
    }

    public function test_admin_can_reset_api_token_for_user()
    {
        $admin = User::factory()->create(['permission' => 2]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->put(route('admin.reset-api-token', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');
    }

    public function test_admin_can_delete_avatar_for_user()
    {
        $admin = User::factory()->create(['permission' => 2]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.delete-avatar', $user->id));
        $response->assertStatus(302)->assertSessionHas('success');
    }

    public function test_admin_can_change_name_email_password_for_user()
    {
        $admin = User::factory()->create(['permission' => 2]);
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

}
