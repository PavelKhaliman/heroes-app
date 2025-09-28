<?php

namespace Tests\Feature;

use App\Models\Guide;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentingTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_comment_on_photo(): void
    {
        $user = User::factory()->create();
        $photo = \App\Models\Photo::factory()->create();

        $this->actingAs($user)
            ->post(route('comments.store'), [
                'type' => 'photo',
                'id' => $photo->id,
                'body' => 'Nice shot',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'commentable_id' => $photo->id,
            'commentable_type' => get_class($photo),
            'body' => 'Nice shot',
        ]);
    }

    public function test_authenticated_user_can_comment_on_guide(): void
    {
        $user = User::factory()->create();
        $guide = Guide::factory()->create();

        $this->actingAs($user)
            ->post(route('comments.store'), [
                'type' => 'guide',
                'id' => $guide->id,
                'body' => 'Good guide',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'commentable_id' => $guide->id,
            'commentable_type' => get_class($guide),
            'body' => 'Good guide',
        ]);
    }
}


