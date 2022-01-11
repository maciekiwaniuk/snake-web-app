<?php

namespace Tests\Feature\AdminTests;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminVisitsPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_visit_pages_which_are_not_secured_by_any_middlewares()
    {
        $admin = User::factory()->create(['permission' => 2]);

        $this->actingAs($admin)->get(route('home'))->assertStatus(200);
        $this->actingAs($admin)->get(route('offline-fallback'))->assertStatus(200);
        $this->actingAs($admin)->get(route('mini-game'))->assertStatus(200);
        $this->actingAs($admin)->get(route('download'))->assertStatus(200);
        $this->actingAs($admin)->get(route('profile', $admin->name))->assertStatus(200);
        $this->actingAs($admin)->get(route('help.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('message.index'))->assertStatus(200);

        $this->actingAs($admin)->get(route('ranking.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('ranking.get-points'))->assertStatus(200);
        $this->actingAs($admin)->get(route('ranking.get-coins'))->assertStatus(200);
        $this->actingAs($admin)->get(route('ranking.get-easy'))->assertStatus(200);
        $this->actingAs($admin)->get(route('ranking.get-medium'))->assertStatus(200);
        $this->actingAs($admin)->get(route('ranking.get-hard'))->assertStatus(200);
        $this->actingAs($admin)->get(route('ranking.get-speed'))->assertStatus(200);
    }

    public function test_admin_can_visit_pages_which_are_secured_by_admin_middleware()
    {
        $admin = User::factory()->create(['permission' => 2]);

        $this->actingAs($admin)->get(route('options.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('options.get-user-login-logs'))->assertStatus(200);
        $this->actingAs($admin)->get(route('password.confirm'))->assertStatus(200);
        $this->actingAs($admin)->post(route('logout'))->assertRedirect(route('home'));
        $this->actingAs($admin)->get(route('verification.notice'))->assertRedirect(route('home'));
    }

    public function test_admin_can_visit_pages_secured_by_admin_middleware()
    {
        $admin = User::factory()->create(['permission' => 2]);

        $this->actingAs($admin)->get(route('admin.users.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('admin.visitors.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('admin.messages.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('admin.app-logs.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('admin.server-logs.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('admin.statistics.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('admin.artisan-tools.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('admin.php-info.index'))->assertStatus(200);
    }

}
