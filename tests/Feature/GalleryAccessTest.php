<?php

namespace Tests\Feature;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_photo_index_is_public(): void
    {
        $this->get(route('gallery.photo.index'))->assertOk();
    }

    public function test_create_requires_auth(): void
    {
        $this->get(route('gallery.photo.create'))->assertRedirect(route('login'));
    }

    public function test_only_owner_or_admin_can_edit_delete(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        $photo = Photo::factory()->for($owner)->create();

        $this->actingAs($other)->get(route('gallery.photo.edit', $photo))->assertStatus(403);
        $this->actingAs($admin)->get(route('gallery.photo.edit', $photo))->assertOk();
        $this->actingAs($owner)->get(route('gallery.photo.edit', $photo))->assertOk();
    }
}


