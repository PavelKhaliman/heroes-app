<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForumAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_see_admin_forum_sections(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->get(route('admin.forum.sections.index'))
            ->assertStatus(403);

        $this->actingAs($admin)
            ->get(route('admin.forum.sections.index'))
            ->assertOk();
    }
}


