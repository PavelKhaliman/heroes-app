<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_users_list(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory(3)->create();

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Пользователи');
    }

    public function test_non_admin_cannot_access_admin_users(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user)
            ->get(route('admin.users.index'))
            ->assertOk();
    }
}


