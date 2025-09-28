<?php

namespace Tests\Feature;

use App\Models\Guide;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikesTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_toggle_like_on_photo(): void
    {
        $user = User::factory()->create();
        $photo = Photo::factory()->create();

        $this->actingAs($user)
            ->post(route('likes.toggle'), [
                'type' => 'photo',
                'id' => $photo->id,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('likes', [
            'likeable_id' => $photo->id,
            'likeable_type' => get_class($photo),
            'user_id' => $user->id,
        ]);

        // Toggle off
        $this->actingAs($user)
            ->post(route('likes.toggle'), [
                'type' => 'photo',
                'id' => $photo->id,
            ])
            ->assertRedirect();

        $this->assertDatabaseMissing('likes', [
            'likeable_id' => $photo->id,
            'likeable_type' => get_class($photo),
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_toggle_like_on_guide(): void
    {
        $user = User::factory()->create();
        $guide = Guide::factory()->create();

        $this->actingAs($user)
            ->post(route('likes.toggle'), [
                'type' => 'guide',
                'id' => $guide->id,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('likes', [
            'likeable_id' => $guide->id,
            'likeable_type' => get_class($guide),
            'user_id' => $user->id,
        ]);
    }
}


