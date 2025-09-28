<?php

namespace App\Services\Social;

use App\Models\Comment;
use App\Models\Guide;
use App\Models\Notification;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function store(string $type, int $id, string $body): Comment
    {
        $userId = Auth::id();
        if (!$userId) abort(403);

        $commentable = $type === 'guide' ? Guide::findOrFail($id) : Photo::findOrFail($id);
        $comment = $commentable->comments()->create([
            'user_id' => $userId,
            'body' => $body,
        ]);

        $ownerId = $commentable->user_id ?? null;
        if ($ownerId && $ownerId !== $userId) {
            $link = $type === 'guide'
                ? route('guide.' . $commentable->kind . '.show', ['guide' => $commentable, 'kind' => $commentable->kind]) . '#comment-' . $comment->id
                : route('gallery.photo.show', $commentable) . '#comment-' . $comment->id;
            Notification::create([
                'user_id' => $ownerId,
                'type' => 'comment.created',
                'data' => [
                    'message' => 'Новый комментарий к вашей записи',
                    'link' => $link,
                ],
            ]);
        }

        return $comment;
    }

    public function update(Comment $comment, string $body): void
    {
        $user = Auth::user();
        if (!$user || ($user->id !== $comment->user_id && $user->role !== 'admin')) abort(403);
        $comment->body = $body;
        $comment->save();
    }

    public function delete(Comment $comment): void
    {
        $user = Auth::user();
        if (!$user || ($user->id !== $comment->user_id && $user->role !== 'admin')) abort(403);
        $comment->delete();
    }
}


