<?php

namespace Tests\Feature\UserTests;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserVisitsPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_visit_pages_which_are_not_secured_by_any_middlewares()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('home'))->assertStatus(200);
        $this->actingAs($user)->get(route('offline-fallback'))->assertStatus(200);
        $this->actingAs($user)->get(route('mini-game'))->assertStatus(200);
        $this->actingAs($user)->get(route('game-hostings.index'))->assertStatus(200);
        $this->actingAs($user)->get(route('profile', $user->name))->assertStatus(200);
        $this->actingAs($user)->get(route('help.index'))->assertStatus(200);
        $this->actingAs($user)->get(route('message.index'))->assertStatus(200);

        $this->actingAs($user)->get(route('ranking.index'))->assertStatus(200);
        $this->actingAs($user)->get(route('ranking.get-points'))->assertStatus(200);
        $this->actingAs($user)->get(route('ranking.get-coins'))->assertStatus(200);
        $this->actingAs($user)->get(route('ranking.get-easy'))->assertStatus(200);
        $this->actingAs($user)->get(route('ranking.get-medium'))->assertStatus(200);
        $this->actingAs($user)->get(route('ranking.get-hard'))->assertStatus(200);
        $this->actingAs($user)->get(route('ranking.get-speed'))->assertStatus(200);
    }

    public function test_user_can_visit_pages_which_are_secured_by_user_middleware()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('options.index'))->assertStatus(200);
        $this->actingAs($user)->get(route('options.get-user-login-logs'))->assertStatus(200);
        $this->actingAs($user)->get(route('password.confirm'))->assertStatus(200);
        $this->actingAs($user)->post(route('logout'))->assertRedirect(route('home'));
        $this->actingAs($user)->get(route('verification.notice'))->assertRedirect(route('home'));
    }

    public function test_user_cannot_visit_pages_secured_by_admin_middleware()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.users.index'))->assertStatus(403);
        $this->actingAs($user)->get(route('admin.visitors.index'))->assertStatus(403);
        $this->actingAs($user)->get(route('admin.messages.index'))->assertStatus(403);
        $this->actingAs($user)->get(route('admin.app-logs.index'))->assertStatus(403);
        $this->actingAs($user)->get(route('admin.server-logs.index'))->assertStatus(403);
        $this->actingAs($user)->get(route('admin.statistics.index'))->assertStatus(403);
        $this->actingAs($user)->get(route('admin.artisan-tools.index'))->assertStatus(403);
        $this->actingAs($user)->get(route('admin.php-info.index'))->assertStatus(403);
    }

}
