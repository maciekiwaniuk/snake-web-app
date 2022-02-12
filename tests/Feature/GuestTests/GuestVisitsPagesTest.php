<?php

namespace Tests\Feature\GuestTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class GuestVisitsPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_visit_pages_which_are_not_secured_by_any_middlewares()
    {
        $user = User::factory()->create();

        $this->get(route('home'))->assertStatus(200);
        $this->get(route('offline-fallback'))->assertStatus(200);
        $this->get(route('mini-game'))->assertStatus(200);
        $this->get(route('game-hostings.index'))->assertStatus(200);
        $this->get(route('profile', $user->name))->assertStatus(200);
        $this->get(route('help.index'))->assertStatus(200);
        $this->get(route('message.index'))->assertStatus(200);

        $this->get(route('ranking.index'))->assertStatus(200);
        $this->get(route('ranking.get-points'))->assertStatus(200);
        $this->get(route('ranking.get-coins'))->assertStatus(200);
        $this->get(route('ranking.get-easy'))->assertStatus(200);
        $this->get(route('ranking.get-medium'))->assertStatus(200);
        $this->get(route('ranking.get-hard'))->assertStatus(200);
        $this->get(route('ranking.get-speed'))->assertStatus(200);

        $this->get(route('register'))->assertStatus(200);
        $this->get(route('login'))->assertStatus(200);
        $this->get(route('password.request'))->assertStatus(200);
    }

    public function test_guest_cannot_visit_pages_secured_by_user_middleware()
    {
        $this->get(route('options.index'))->assertRedirect(route('login'));
        $this->get(route('options.get-user-login-logs'))->assertRedirect(route('login'));
        $this->get(route('verification.notice'))->assertRedirect(route('login'));
        $this->get(route('password.confirm'))->assertRedirect(route('login'));
    }

    public function test_guest_cannot_visit_pages_secured_by_admin_middleware()
    {
        $this->get(route('admin.users.index'))->assertStatus(403);
        $this->get(route('admin.visitors.index'))->assertStatus(403);
        $this->get(route('admin.messages.index'))->assertStatus(403);
        $this->get(route('admin.game-hostings.index'))->assertStatus(403);
        $this->get(route('admin.app-logs.index'))->assertStatus(403);
        $this->get(route('admin.server-logs.index'))->assertStatus(403);
        $this->get(route('admin.statistics.index'))->assertStatus(403);
        $this->get(route('admin.artisan-tools.index'))->assertStatus(403);
        $this->get(route('admin.php-info.index'))->assertStatus(403);
    }

}
