<?php

namespace Tests\Feature;

use App\Models\Guide;
use App\Models\Notification;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_gets_notification_on_new_comment_photo(): void
    {
        $owner = User::factory()->create();
        $commenter = User::factory()->create();
        $photo = Photo::factory()->for($owner)->create();

        $this->actingAs($commenter)
            ->post(route('comments.store'), [
                'type' => 'photo',
                'id' => $photo->id,
                'body' => 'Ping',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('notifications', [
            'user_id' => $owner->id,
            'type' => 'comment.created',
        ]);
    }

    public function test_owner_gets_notification_on_new_comment_guide(): void
    {
        $owner = User::factory()->create();
        $commenter = User::factory()->create();
        $guide = Guide::factory()->for($owner)->create();

        $this->actingAs($commenter)
            ->post(route('comments.store'), [
                'type' => 'guide',
                'id' => $guide->id,
                'body' => 'Ping',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('notifications', [
            'user_id' => $owner->id,
            'type' => 'comment.created',
        ]);
    }
}


