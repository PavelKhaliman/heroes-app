<?php

namespace Tests\Feature;

use App\Models\Guide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GuidesCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_edit_delete_own_guide(): void
    {
        // No file upload needed for this flow
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create
        $resp = $this->post(route('guide.east.store', ['kind' => 'east']), [
            'title' => 'Test Guide',
            'excerpt' => 'Short',
            'body' => 'Body',
        ]);
        $resp->assertRedirect();
        $guide = Guide::first();
        $this->assertNotNull($guide);

        // Edit
        $this->get(route('guide.east.edit', ['guide' => $guide, 'kind' => 'east']))->assertOk();
        $this->put(route('guide.east.update', ['guide' => $guide, 'kind' => 'east']), [
            'title' => 'Updated',
            'excerpt' => 'Short',
            'body' => 'New',
        ])->assertRedirect();
        $this->assertDatabaseHas('guides', ['id' => $guide->id, 'title' => 'Updated']);

        // Delete
        $this->delete(route('guide.east.destroy', ['guide' => $guide, 'kind' => 'east']))->assertRedirect();
        $this->assertDatabaseMissing('guides', ['id' => $guide->id]);
    }
}


